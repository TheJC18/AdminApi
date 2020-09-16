<?php

namespace App\Http\Controllers;

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
      $Dolars = Dolar::select("dolares.*")
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Dolars
      ]);
    }

    public function indexDelete()
    {
        $Dolars = Dolar::select("dolares.*")
        ->onlyTrashed()
        ->get();
  

      return response()->json([
        "ok" => true,
        "data" => $Dolars
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    }
}
