<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DetallesTmpcotizacion;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Tmp_cotizacion;
use Validator, DB;

class Tmp_cotizacionController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_tmpc');
      if($permiso == '1'){

        $Tmp_cotizacions = Tmp_cotizacion::select("Tmp_cotizacion.*")
        ->where('estatus','=','1')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Tmp_cotizacions
        ]);

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_tmpc');
      if($permiso == '1'){

        $Tmp_cotizacions = Tmp_cotizacion::select("Tmp_cotizacion.*")
        ->where('estatus','=','0')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Tmp_cotizacions
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
      $permiso = Auth::user()->hasPermissionTo('crear_tmpc');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'codigo' => 'required|numeric|unique:Tmp_cotizacion',
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

          Tmp_cotizacion::create($input);

        }catch(\Exception $ex){
          
          DB::rollBack();

          return response()->json([
              'ok' => false, 
              'error' => $ex->getMessage()
          ]);
        }

        try{

          DetallesTmpcotizacion::create($request->all());
          DB::commit();
        
          return response()->json([
            'ok' => true, 
            'message' => "Se registro con exito el seguimiento de la Tmp_cotizacion"
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
      $permiso = Auth::user()->hasPermissionTo('ver_tpmc');
      if($permiso == '1'){

        $Tmp_cotizacion = Tmp_cotizacion::find($id);

        if ($Tmp_cotizacion == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro la Tmp_cotizacion"
          ]);
        }
        $Tmp_cotizacions = Tmp_cotizacion::select("Tmp_cotizacion.*")
        ->where("Tmp_cotizacion.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Tmp_cotizacions
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_tmpc');
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

          $Tmp_cotizacion = Tmp_cotizacion::find($id);

          if ($Tmp_cotizacion == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro la Tmp_cotizacion"
            ]);
          }

          $Tmp_cotizacion->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico la Tmp_cotizacion con exito"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_tmpc');
      if($permiso == '1'){

        try{

          $Tmp_cotizacion = Tmp_cotizacion::findOrFail($id);

          if ($Tmp_cotizacion == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro la Tmp_cotizacion"
            ]);
          }

          $Tmp_cotizacion = Tmp_cotizacion::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino la Tmp_cotizacion con exito"
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
