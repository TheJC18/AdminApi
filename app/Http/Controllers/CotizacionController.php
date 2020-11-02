<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
      $permiso = Auth::user()->hasPermissionTo('listado_cotizacion');
      if($permiso == '1'){
        $Cotizacions = Cotizacion::select("cotizacion.*")
        ->where('estatus',1)->get();

        return response()->json([
        "ok" => true,
        "data" => $Cotizacions
        ]);
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_cotizacion');
      if($permiso == '1'){
        $Cotizacions = Cotizacion::select("cotizacion.*")
        ->where('estatus','=','0')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Cotizacions
        ]);
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $permiso = Auth::user()->hasPermissionTo('crear_cotizacion');
      if($permiso == '1'){
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

        foreach ($productos as $i) {
        $P = Producto::select("producto.*")
          ->where("id", $i["id"])
          ->first();
                  
        
        if ($P != false) {
            if($P->cantidad >= $i["cantidad"]){

              $nueva = ($P->cantidad - $i["cantidad"]);

              DB::table('producto')->where('id', $i['id'])->update(array('cantidad' => $nueva));

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
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
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
      $permiso = Auth::user()->hasPermissionTo('ver_cotizacion');
      if($permiso == '1'){
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
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_cotizacion');
      if($permiso == '1'){

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
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_cotizacion');
      if($permiso == '1'){
        
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

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }
}
