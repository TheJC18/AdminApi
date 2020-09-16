<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Departamento;
use Validator, DB;

class DepartamentoController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $Departamentos = Departamento::select("departamento.*")
      ->where('departamento.estatus','=','1')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Departamentos
      ]);
    }

    public function indexDelete()
    {
      $Departamentos = Departamento::select("departamento.*")
      ->where('departamento.estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Departamentos
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
          'codigo' => 'required|string|unique:departamento',
          'descripcion' => 'required|max:150|string',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Departamento::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el departamento"
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
      $Departamento = Departamento::find($id);

          if ($Departamento == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta mejor departamento"
            ]);
          }
      $Departamentos = Departamento::select("departamento.*")
      ->where("departamento.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $Departamentos
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
          'codigo' => 'required|numeric|unique:departamento',
          'descripcion' => 'required|max:150|string',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Departamento = Departamento::find($id);

          if ($Departamento == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro este departamento"
            ]);
          }

          $Departamento->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico con exito este departamento"
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

          $Departamento = Departamento::findOrFail($id);

          if ($Departamento == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro esta mes"
            ]);
          }

          $Departamento = Departamento::findOrFail($id)
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
