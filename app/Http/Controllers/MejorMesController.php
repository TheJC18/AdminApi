<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MejorMes;
use Validator, DB;

class MejorMesController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_mes');
      if($permiso == '1'){

        $MejorMess = MejorMes::select("mejor_mes.*")
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $MejorMess
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
      $permiso = Auth::user()->hasPermissionTo('crear_mes');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'ventas' => 'required|numeric',
          'año' => 'required|numeric',
          'mes' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          MejorMes::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el mes"
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
      $permiso = Auth::user()->hasPermissionTo('ver_mes');
      if($permiso == '1'){

        $MejorMes = MejorMes::find($id);

        if ($MejorMes == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro esta mejor mes"
          ]);
        }

        $MejorMess = MejorMes::select("mejor_mes.*")
        ->where("mejor_mes.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $MejorMess
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_mes');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'ventas' => 'required|numeric',
          'año' => 'required|numeric',
          'mes' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $MejorMes = MejorMes::find($id);

          if ($MejorMes == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro este mes"
            ]);
          }

          $MejorMes->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico con exito este mes"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_mes');
      if($permiso == '1'){

        try{

          $MejorMes = MejorMes::findOrFail($id);

          if ($MejorMes == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta mes"
            ]);
          }

          $MejorMes->delete();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se Elimino con exito"
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
