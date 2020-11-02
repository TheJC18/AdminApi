<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Moneda;
use Validator, DB;

class MonedaController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_moneda');
      if($permiso == '1'){

        $Monedas = Moneda::select("moneda.*")
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Monedas
        ]);

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }

    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_moneda');
      if($permiso == '1'){
        
      $Monedas = Moneda::select("moneda.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Monedas
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
      $permiso = Auth::user()->hasPermissionTo('crear_moneda');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'descripcion' => 'required|max:65|unique:moneda',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Moneda::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito la moneda"
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

        $Moneda = Moneda::find($id);

        if ($Moneda == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro esta moneda"
          ]);
        }
        $Monedas = Moneda::select("moneda.*")
        ->where("moneda.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Monedas
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_moneda');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'descripcion' => 'required|max:255',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Moneda = Moneda::find($id);

          if ($Moneda == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta Moneda"
            ]);
          }

          $Moneda->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico con exito"
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
      $permiso = Auth::user()->hasPermissionTo('eliminar_moneda');
      if($permiso == '1'){

        try{

          $Moneda = Moneda::findOrFail($id);

          if ($Moneda == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta Moneda"
            ]);
          }

          $Moneda = Moneda::findOrFail($id)
          ->update(['estatus'=>'0']);
          
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
