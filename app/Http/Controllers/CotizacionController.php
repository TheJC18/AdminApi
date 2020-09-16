<?php

namespace App\Http\Controllers;

use App\Models\CotizacionSeguimiento;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Producto;
use Validator, DB;

class CotizacionController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $Cotizacions = Cotizacion::select("cotizacion.*")
      ->where('estatus',1)->get();

      return response()->json([
        "ok" => true,
        "data" => $Cotizacions
      ]);
    }

    public function indexDelete()
    {
      $Cotizacions = Cotizacion::select("cotizacion.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Cotizacions
      ]);
    }
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //Creacion de la cotizacion, con su seguimmiento y la carga de cada uno de lso productos
      DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'codigo' => 'required|string',
          'iva' => 'required|numeric',
          'nota' => 'required|max:250|string',
          'subtotal' => 'required|numeric',
          'total' => 'required|numeric',
          'forma_pago' => 'required|string|max:120',          
          'tiempo_entrega' => 'required|string|max:120',
          'validez' => 'required|string|max:120',
          'tasa' => 'required|numeric',
          'cod_cliente' => 'required|numeric',
          'estatus' => 'required|numeric',
          'usuario' => 'required|numeric',
      ]);

      if ($validator->fails()) {
          return response()->json([
            'ok' => false, 
            'error' => $validator->messages()
          ]);
      }

      try{

        Cotizacion::create($input);

        }catch(\Exception $ex){
          
          DB::rollBack();
          
          return response()->json([
              'ok' => false, 
              'error' => $ex->getMessage()
          ]);
        }
      
        try{

          CotizacionSeguimiento::create($input);
  
          }catch(\Exception $ex){
            
            DB::rollBack();
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }

        // Carga del array con sus productos
        try{
          //json_decode
          $productos = $request["array"];

          foreach (json_decode($productos) as $i) {
          
          $P = Producto::select("producto.*")
            ->where("id", $i->id)
            ->first();
                    
          
          if ($P != false) {
              if($P->cantidad >= $i->cantidad){

                $P::update($i);

              }else{
              
                return response()->json([
                  'ok' => true, 
                  'error' => "La cantidad de productos es mayor a la disponible"
                ]);
              }
           }else 
          
              return response()->json([
                'ok' => true, 
                'error' => "Hubo un error al agregar un producto, revise los campos que seleccionó"
              ]);
          
          }

          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el seguimiento de la cotizacion"
            ]);

        }catch(\Exception $ex){
            
          DB::rollBack();
          
          return response()->json([
              'ok' => false, 
              'error' => $ex->getMessage()
          ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $Cotizacion = Cotizacion::find($id);

          if ($Cotizacion == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro la Cotizacion"
            ]);
          }
      $Cotizacions = Cotizacion::select("Cotizacion.*")
      ->where("Cotizacion.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $Cotizacions
      ]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
            'iva' => 'required|numeric',
            'nota' => 'required|max:250|string',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'forma_pago' => 'required|string|max:120',          
            'tiempo_entrega' => 'required|string|max:120',
            'validez' => 'required|string|max:120',
            'tasa' => 'required|numeric',
            'cod_cliente' => 'required|numeric',
            'estatus' => 'required|numeric',
            'usuario' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Cotizacion = Cotizacion::find($id);

          if ($Cotizacion == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro la Cotizacion"
            ]);
          }

          $Cotizacion->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico la Cotizacion con exito"
            ]);

          }catch(\Exception $ex){
            
            DB::rollBack();
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

          $Cotizacion = Cotizacion::findOrFail($id);

          if ($Cotizacion == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro la Cotizacion"
            ]);
          }

          $Cotizacion = Cotizacion::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se laimino la Cotizacion con exito"
            ]);

          }catch(\Exception $ex){
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }
    }
}
