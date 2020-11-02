<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Dolar;
use Validator, DB;

class DolarController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_dolar');
      if($permiso == '1'){

        $Dolars = Dolar::select("dolares.*")
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Dolars
        ]);

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_dolar');
      if($permiso == '1'){

        $Dolars = Dolar::select("dolares.*")
        ->onlyTrashed()
        ->get();

        return response()->json([
          "ok" => true,
          "data" => $Dolars
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
      $permiso = Auth::user()->hasPermissionTo('crear_dolar');
      if($permiso == '1'){


        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'monto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Dolar::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito la tasa del dolar"
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
      $permiso = Auth::user()->hasPermissionTo('ver_dolar');
      if($permiso == '1'){
        $Dolar = Dolar::find($id);

        if ($Dolar == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro esta Dolar"
          ]);
        }
        $Dolars = Dolar::select('dolares.*')
        ->where("dolares.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Dolars
        ]);
        
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_dolar');
      if($permiso == '1'){
        try{

          $Dolar = Dolar::findOrFail($id);

          if ($Dolar == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta Dolar"
            ]);
          }

          $Dolar->delete();
          
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
