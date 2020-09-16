<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Proveedor;
use Validator, DB;

class ProveedorController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $Proveedors = Proveedor::select("Proveedor.*")
      ->where('estatus','=','1')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Proveedors
      ]);
    }

    public function indexDelete()
    {
      $Proveedors = Proveedor::select("Proveedor.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Proveedors
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
          'codigo' => 'required|numeric|unique:Proveedor',
          'nombre' => 'required|max:150|string',
          'correo' => 'required|max:150|email',
          'direccion' => 'required|max:300|string',
          'contacto' => 'required|max:50|string',
          'telefono' => 'required|max:120|string',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Proveedor::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el Proveedor"
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
      $Proveedor = Proveedor::find($id);

          if ($Proveedor == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Proveedor"
            ]);
          }
      $Proveedors = Proveedor::select("Proveedor.*")
      ->where("Proveedor.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $Proveedors
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
          'nombre' => 'required|max:150|string',
          'correo' => 'required|max:150|email',
          'direccion' => 'required|max:300|string',
          'contacto' => 'required|max:50|string',
          'telefono' => 'required|max:120|string',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Proveedor = Proveedor::find($id);

          if ($Proveedor == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Proveedor"
            ]);
          }

          $Proveedor->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el Proveedor con exito"
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

          $Proveedor = Proveedor::findOrFail($id);

          if ($Proveedor == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el Proveedor"
            ]);
          }

          $Proveedor = Proveedor::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el Proveedor con exito"
            ]);

          }catch(\Exception $ex){
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }
    }
}
