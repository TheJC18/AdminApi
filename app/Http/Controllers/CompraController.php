<?php

namespace App\Http\Controllers;

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
      $Compras = Compra::select("compra.*")
      ->where('estatus','=','1')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Compras
      ]);
    }

    public function indexDelete()
    {
      $Compras = Compra::select("compra.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Compras
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    }
}
