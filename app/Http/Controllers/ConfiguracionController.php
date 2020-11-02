<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Configuracion;
use Validator, DB;

class ConfiguracionController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_configuracion');
      if($permiso == '1'){
        $Configuracions = Configuracion::select("configuracion.*")
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Configuracions
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
      $permiso = Auth::user()->hasPermissionTo('crear_configuracion');
      if($permiso == '1'){
        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'descripcion' => 'required|max:100|string',
          'cod_usuario' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Configuracion::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito la Configuracion"
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
      $permiso = Auth::user()->hasPermissionTo('ver_configuracion');
      if($permiso == '1'){

        $Configuracion = Configuracion::find($id);

        if ($Configuracion == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro la Configuracion"
          ]);
        }
        $Configuracions = Configuracion::select("configuracion.*")
        ->where("configuracion.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Configuracions
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_configuracion');
      if($permiso == '1'){
        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
            'descripcion' => 'required|max:100|string',
            'cod_usuario' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Configuracion = Configuracion::find($id);

          if ($Configuracion == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro la Configuracion"
            ]);
          }

          $Configuracion->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico la Configuracion con exito"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_configuracion');
      if($permiso == '1'){
        
        try{

          $Configuracion = Configuracion::findOrFail($id);

          if ($Configuracion == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro la Configuracion"
            ]);
          }

          $Configuracion = Configuracion::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se laimino la Configuracion con exito"
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
