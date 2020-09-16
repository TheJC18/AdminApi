<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Equilibrio;
use Validator, DB;

class EquilibrioController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $Equilibrios = Equilibrio::select("Equilibrio.*")
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Equilibrios
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
          'codigo' => 'required|numeric|unique:Equilibrio',
          'ano' => 'required|numeric',
          'mes' => 'required|numeric',
          'monto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Equilibrio::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el equilibrio"
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
      $Equilibrio = Equilibrio::find($id);

          if ($Equilibrio == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el equilibrio"
            ]);
          }
      $Equilibrios = Equilibrio::select("Equilibrio.*")
      ->where("Equilibrio.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $Equilibrios
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
            'ano' => 'required|numeric',
            'mes' => 'required|numeric',
            'monto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Equilibrio = Equilibrio::find($id);

          if ($Equilibrio == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el equilibrio"
            ]);
          }

          $Equilibrio->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el equilibrio con exito"
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

          $Equilibrio = Equilibrio::findOrFail($id);

          if ($Equilibrio == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el equilibrio"
            ]);
          }

          $Equilibrio->delete();

          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el equilibrio con exito"
            ]);

          }catch(\Exception $ex){
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }
    }
}
