<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Compra;
use Validator, DB;

class CompraController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_compra');
      if($permiso == '1'){
        $Compras = Compra::select("compra.*")
        ->where('estatus','=','1')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Compras
        ]);
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }      
    }

    public function indexDelete()
    {
      $permiso = Auth::user()->hasPermissionTo('listado_e_compra');
      if($permiso == '1'){
        $Compras = Compra::select("compra.*")
        ->where('estatus','=','0')
        ->get();
  
        return response()->json([
          "ok" => true,
          "data" => $Compras
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
      $permiso = Auth::user()->hasPermissionTo('crear_compra');
      if($permiso == '1'){

        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'codigo' => 'required|numeric|unique:Compra',
          'cod_documento' => 'required|numeric',
          'num_control' => 'required|numeric',
          'fecha_documento' => 'required|date',
          'sub_total' => 'required',
          'impuesto' => 'required',          
          'total' => 'required',
          'nota' => 'required|max:600|string',
          'estatus' => 'required|numeric',
          'cod_proveedor' => 'required|numeric',
          'usuario' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Compra::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el Compra"
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
      $permiso = Auth::user()->hasPermissionTo('ver_compra');
      if($permiso == '1'){
        $Compra = Compra::find($id);

        if ($Compra == false) {
           return response()->json([
            'ok' => false, 
            'error' => "No se encontro el Compra"
          ]);
        }
        $Compras = Compra::select("compra.*")
        ->where("compra.id", $id)
        ->first();

        return response()->json([
          "ok" => true,
          "data" => $Compras
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
      $permiso = Auth::user()->hasPermissionTo('actualizar_compra');
      if($permiso == '1'){
        DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
            'cod_documento' => 'required|numeric',
            'num_control' => 'required|numeric',
            'fecha_documento' => 'required|date',
            'sub_total' => 'required',
            'impuesto' => 'required',          
            'total' => 'required',
            'nota' => 'required|max:600|string',
            'estatus' => 'required|numeric',
            'cod_proveedor' => 'required|numeric',
            'usuario' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Compra = Compra::find($id);

          if ($Compra == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Compra"
            ]);
          }

          $Compra->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el Compra con exito"
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
      $permiso = Auth::user()->hasPermissionTo('ver_ajuste');
      if($permiso == '1'){
        try{

          $Compra = Compra::findOrFail($id);

          if ($Compra == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Compra"
            ]);
          }

          $Compra = Compra::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el Compra con exito"
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
