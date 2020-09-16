<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cliente;
use Validator, DB;

class ClienteController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $Clientes = Cliente::select("cliente.*")
      ->where('estatus','=','1')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Clientes
      ]);
    }

    public function indexDelete()
    {
      $Clientes = Cliente::select("cliente.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Clientes
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
          'codigo' => 'required|numeric|unique:cliente',
          'nombre' => 'required|max:75|string',
          'correo' => 'required|max:50|email',
          'direccion' => 'required|max:150|string',
          'contacto' => 'required|max:50|string',
          'telefono' => 'required|max:120|string',
          'tipo_contribuyente' => 'required|max:50|string',
          'retencion' => 'required|numeric',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          Cliente::create($input);
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'message' => "Se registro con exito el cliente"
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
      $Cliente = Cliente::find($id);

          if ($Cliente == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el cliente"
            ]);
          }
      $Clientes = Cliente::select("cliente.*")
      ->where("cliente.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $Clientes
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
            'nombre' => 'required|max:75|string',
            'correo' => 'required|max:50|email',
            'direccion' => 'required|max:150|string',
            'contacto' => 'required|max:50|string',
            'telefono' => 'required|max:120|string',
            'tipo_contribuyente' => 'required|max:50|string',
            'retencion' => 'required|numeric',
            'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Cliente = Cliente::find($id);

          if ($Cliente == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el cliente"
            ]);
          }

          $Cliente->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el cliente con exito"
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

          $Cliente = Cliente::findOrFail($id);

          if ($Cliente == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el cliente"
            ]);
          }

          $Cliente = Cliente::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el cliente con exito"
            ]);

          }catch(\Exception $ex){
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }
    }
}
