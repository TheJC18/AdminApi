<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Unidad;
use Validator, DB;

class UnidadController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_unidad');
      if($permiso == '1'){

        $Unidads = Unidad::select("unidad.*")
        ->where('unidad.estatus','=','1')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Unidads
        ]);

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_unidad');
      if($permiso == '1'){

        $Unidads = Unidad::select("unidad.*")
        ->where('unidad.estatus','=','0')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Unidads
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
      $permiso = Auth::user()->hasPermissionTo('crear_tpmc');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'codigo' => 'required|numeric|unique:unidad',
          'descripcion' => 'required|max:120',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Unidad::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro la unidad con exito"
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
      $permiso = Auth::user()->hasPermissionTo('ver_unidad');
      if($permiso == '1'){

        $Unidad = Unidad::find($id);

        if ($Unidad == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro esta unidad"
          ]);
        }
        
        $Unidads = Unidad::select("unidad.*")
        ->where("unidad.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Unidads
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_unidad');
      if($permiso == '1'){
        
      DB::beginTransaction();

      $input = $request->all();

      $validator = Validator::make($input, [
        'descripcion' => 'required|max:120',
        'estatus' => 'required|numeric',        
      ]);

      if ($validator->fails()) {
          return response()->json([
            'ok' => false, 
            'error' => $validator->messages()
          ]);
      }

      try{

        $Unidad = Unidad::find($id);

        if ($Unidad == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro esta Unidad"
          ]);
        }

        $Unidad->update($input);
        DB::commit();

        return response()->json([
            'ok' => true, 
            'message' => "Se modifico la unidad con exito"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_unidad');
      if($permiso == '1'){

        try{

          $Unidad = Unidad::findOrFail($id);

          if ($Unidad == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta Unidad"
            ]);
          }

          $Unidad = Unidad::findOrFail($id)
          ->update(['estatus'=>'0']);
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino la unidad con exito"
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
