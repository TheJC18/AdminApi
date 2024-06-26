<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ordencompra;
use App\Models\OrdenSeguimiento;
use App\Models\Detalleordencompra;
use Validator, DB;

class OrdencompraController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_orden');
      if($permiso == '1'){
        
      $Ordencompras = Ordencompra::select("Ordencompra.*")
      ->where('estatus','=','1')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Ordencompras
      ]);

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_orden');
      if($permiso == '1'){

        $Ordencompras = Ordencompra::select("Ordencompra.*")
        ->where('estatus','=','0')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Ordencompras
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
      $permiso = Auth::user()->hasPermissionTo('crear_orden');
      if($permiso == '1'){
        
      DB::beginTransaction();

      $input = $request->all();

      $validator = Validator::make($input, [
        'codigo' => 'required|numeric|unique:ordencompra',
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
        'forma_pago' => 'required|max:120|string',
        'tiempo_entrega' => 'required|max:120|string',
        'validez' => 'required|max:120|string',
        'nota' => 'required|max:250|string',
        'cod_proveedor' => 'required|numeric',
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

        Ordencompra::create($input);

      }catch(\Exception $ex){
        
        DB::rollBack();

        return response()->json([
            'ok' => false, 
            'error' => $ex->getMessage()
        ]);
      }

      try{

          Detalleordencompra::create($input);

        }catch(\Exception $ex){
          
          DB::rollBack();

          return response()->json([
              'ok' => false, 
              'error' => $ex->getMessage()
          ]);
        }

        try{

          OrdenSeguimiento::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito la orden de compra, su detalle y su seguimiento"
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
      $Ordencompra = Ordencompra::find($id);

          if ($Ordencompra == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Ordencompra"
            ]);
          }
      $Ordencompras = Ordencompra::select("ordencompra.*")
      ->where("ordencompra.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $Ordencompras
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_orden');
      if($permiso == '1'){
        
      DB::beginTransaction();

      $input = $request->all();

      $validator = Validator::make($input, [
          'subtotal' => 'required|numeric',
          'total' => 'required|numeric',
          'forma_pago' => 'required|max:120|string',
          'tiempo_entrega' => 'required|max:120|string',
          'validez' => 'required|max:120|string',
          'nota' => 'required|max:250|string',
          'cod_proveedor' => 'required|numeric',
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

        $Ordencompra = Ordencompra::find($id);

        if ($Ordencompra == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro el Ordencompra"
          ]);
        }

        $Ordencompra->update($input);
        DB::commit();

        return response()->json([
            'ok' => true, 
            'message' => "Se modifico el Ordencompra con exito"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_orden');
      if($permiso == '1'){
        try{

          $Ordencompra = Ordencompra::findOrFail($id);

          if ($Ordencompra == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el orden de compra"
            ]);
          }

          $Ordencompra = Ordencompra::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino la orden de compra con exito"
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
