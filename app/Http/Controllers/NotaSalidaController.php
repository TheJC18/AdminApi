<?php

namespace App\Http\Controllers;

use Validator, DB;
use App\Models\NotaSalida;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DetallesNotas;

class NotaSalidaController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $NotaSalidas = NotaSalida::select("NotaSalida.*")
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $NotaSalidas
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
          'codigo' => 'required|numeric',
          'total' => 'required|numeric',
          'nota' => 'required|string|max:200',
          'cod_cliente' => 'required|numeric',
          'usuario' => 'required|numeric',
          'estatus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

          try{

            NotaSalida::create($input);
  
          }catch(\Exception $ex){
            
            DB::rollBack();
  
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }

          try{

            DetallesNotas::create($request->all());
            DB::commit();
            
            return response()->json([
                'ok' => true, 
                'message' => "Se registro con exito la orden de compra, su detalle y su seguimiento"
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
      $NotaSalida = NotaSalida::find($id);

          if ($NotaSalida == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el NotaSalida"
            ]);
          }
      $NotaSalidas = NotaSalida::select("NotaSalida.*")
      ->where("NotaSalida.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $NotaSalidas
      ]);
    }
}
