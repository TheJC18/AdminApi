<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Factura;
use App\Models\Detallefactura;
use Validator, DB;

class FacturaController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_factura');
      if($permiso == '1'){
        $Facturas = Factura::select("Factura.*")
        ->where('estatus','=','1')
        ->get();

        return response()->json([
          "ok" => true,
          "data" => $Facturas
        ]);
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_factura');
      if($permiso == '1'){
        $Facturas = Factura::select("Factura.*")
        ->where('estatus','=','0')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Facturas
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
      $permiso = Auth::user()->hasPermissionTo('crear_factura');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'codigo' => 'required|numeric|unique:Factura',
          'condicion' => 'required|max:20|string',
          'porc_impuesto' => 'required|numeric',
          'costo' => 'required|numeric',
          'iva' => 'required|numeric',
          'subtotal' => 'required|numeric',          
          'total' => 'required|numeric',
          'observacion' => 'required|string|max:300',
          'cod_cliente' => 'required|numeric',
          'usuario' => 'required|numeric',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Factura::create($input);

        }catch(\Exception $ex){
          
          DB::rollBack();

          return response()->json([
              'ok' => false, 
              'error' => $ex->getMessage()
          ]);
        }


        try{

            Detallefactura::create($input);
            DB::commit();
            
            return response()->json([
                'ok' => true, 
                'message' => "Se registro con exito la factura y su detalle"
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
      $permiso = Auth::user()->hasPermissionTo('ver_factura');
      if($permiso == '1'){
        
      $Factura = Factura::find($id);

      if ($Factura == false) {
         return response()->json([
          'ok' => false, 
          'error' => "No se encontro el Factura"
        ]);
      }
        $Facturas = Factura::select("Factura.*")
        ->where("Factura.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Facturas
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_factura');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
            'condicion' => 'required|max:20|string',
            'porc_impuesto' => 'required|numeric',
            'costo' => 'required|numeric',
            'iva' => 'required|numeric',
            'subtotal' => 'required|numeric',          
            'total' => 'required|numeric',
            'observacion' => 'required|string|max:300',
            'cod_cliente' => 'required|numeric',
            'usuario' => 'required|numeric',
            'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Factura = Factura::find($id);

          if ($Factura == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Factura"
            ]);
          }

          $Factura->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el Factura con exito"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_factura');
      if($permiso == '1'){

        try{

          $Factura = Factura::findOrFail($id);

          if ($Factura == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Factura"
            ]);
          }

          $Factura = Factura::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el Factura con exito"
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
      }    }
}
