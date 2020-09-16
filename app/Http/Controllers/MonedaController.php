<?php

namespace App\Http\Controllers;

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
      $Monedas = Moneda::select("moneda.*")
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Monedas
      ]);
    }

    public function indexDelete()
    {
      $Monedas = Moneda::select("moneda.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Monedas
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    }
}
