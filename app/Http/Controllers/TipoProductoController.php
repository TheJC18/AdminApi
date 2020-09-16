<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TipoProducto;
use Validator, DB;

class TipoProductoController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $TipoProductos = TipoProducto::select("tipoproducto.*")
      ->where('estatus','=','1')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $TipoProductos
      ]);
    }

    public function indexDelete()
    {
      $TipoProductos = TipoProducto::select("tipoproducto.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $TipoProductos
      ]);
    }
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
          'codigo' => 'required|numeric|unique:TipoProducto',
          'descripcion' => 'required|max:120|string',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          TipoProducto::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el tipo de producto"
            ]);

        }catch(\Exception $ex){
          
          DB::rollBack();

          return response()->json([
              'ok' => false, 
              'error' => $ex->getMessage()
          ]);
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
      $TipoProducto = TipoProducto::find($id);

          if ($TipoProducto == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el tipo de producto"
            ]);
          }
      $TipoProductos = TipoProducto::select("tipoproducto.*")
      ->where("tipoproducto.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $TipoProductos
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
      DB::beginTransaction();

        $input = $request->all();

        $validator = Validator::make($input, [
            'descripcion' => 'required|max:120|string',
            'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $TipoProducto = TipoProducto::find($id);

          if ($TipoProducto == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el tipo de producto"
            ]);
          }

          $TipoProducto->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el tipo de producto con exito"
            ]);

          }catch(\Exception $ex){
            
            DB::rollBack();
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
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
        try{

          $TipoProducto = TipoProducto::findOrFail($id);

          if ($TipoProducto == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el tipo de producto"
            ]);
          }

          $TipoProducto = TipoProducto::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el tipo de producto con exito"
            ]);

          }catch(\Exception $ex){
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }
    }
}
