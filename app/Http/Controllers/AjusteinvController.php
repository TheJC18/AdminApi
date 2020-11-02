<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ajusteinv;
use App\Models\Detalleajusteinv;
use Validator, DB;

class AjusteinvController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      $permiso = Auth::user()->hasPermissionTo('listado_ajuste');

      if($permiso == '1'){

        $Ajusteinvs = Ajusteinv::select("Ajusteinv.*")
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Ajusteinvs
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
      $permiso = Auth::user()->hasPermissionTo('crear_ajuste');

      if($permiso == '1'){
        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'codigo' => 'required|numeric|unique:ajusteinv',
          'tipo_ajuste' => 'required|max:20|string',
          'fecha' => 'required|date',
          'nota' => 'required|max:200|string',
          'usuario' => 'required|max:11|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Ajusteinv::create($input);

        }catch(\Exception $ex){
          
          DB::rollBack();

          return response()->json([
              'ok' => false, 
              'error' => $ex->getMessage()
          ]);
        }

        try{

          Detalleajusteinv::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el ajuste y su detalle"
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
      $permiso = Auth::user()->hasPermissionTo('ver_ajuste');
      if($permiso == '1'){
        $Ajusteinv = Ajusteinv::find($id);

          if ($Ajusteinv == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta ajuste"
            ]);
          }
        $Ajusteinvs = Ajusteinv::select("ajusteinv.*")
        ->where("ajusteinv.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Ajusteinvs
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_ajuste');
      if($permiso == '1'){
        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
            'tipo_ajuste' => 'required|max:20|string',
            'fecha' => 'required|date',
            'nota' => 'required|max:200|string',
            'usuario' => 'required|max:11|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Ajusteinv = Ajusteinv::find($id);

          if ($Ajusteinv == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta ajuste"
            ]);
          }

          $Ajusteinv->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el ajuste con exito"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_ajuste');
      if($permiso == '1'){
        try{

          $Ajusteinv = Ajusteinv::findOrFail($id);

          if ($Ajusteinv == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta ajuste"
            ]);
          }

          $Ajusteinv = Ajusteinv::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el ajuste con exito"
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
