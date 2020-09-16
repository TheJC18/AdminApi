<?php

namespace App\Http\Controllers;

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
      $MejorMess = MejorMes::select("mejor_mes.*")
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $MejorMess
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    }
}
