<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Producto;
use App\Models\Departamento;
use Illuminate\Support\Str;

use Validator, DB;

class ProductoController extends Controller
{  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $Productos = Producto::select("producto.*")
      ->where('estatus','=','1')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Productos
      ]);
    }

    public function indexDelete()
    {
      $Productos = Producto::select("producto.*")
      ->where('estatus','=','0')
      ->get();

      return response()->json([
        "ok" => true,
        "data" => $Productos
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

        $depar = Departamento::find($request->departamento)->codigo; 
        $num = Producto::where('departamento', '=', $request->departamento)->count();
        $codigo = $depar.($num+1);

        $validator = Validator::make($input, [
          'departamento' => 'required|string',
          'descripcion' => 'required|max:300|string',
          'enser' => 'required|numeric',
          'unidad' => 'required|numeric',
          'precio1' => 'required|numeric',          
          'precio2' => 'required|numeric',
          'precio3' => 'required|numeric',
          'cantidad' => 'required|numeric',
          'imagen' => 'required|string',
          'estatus' => 'required|numeric',
          'tipo' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

            $Producto = new Producto();
            $Producto->codigo = $codigo;
            $Producto->departamento = $request->departamento;
            $Producto->descripcion = $request->descripcion;
            $Producto->enser = $request->enser;
            $Producto->unidad = $request->unidad;
            $Producto->precio1 = $request->precio1;
            $Producto->precio2 = $request->precio2;
            $Producto->precio3 = $request->precio3;
            $Producto->cantidad = $request->cantidad;
            $Producto->imagen = $request->imagen;
            $Producto->estatus = $request->estatus;
            $Producto->tipo = $request->tipo;
            $Producto->save();
          DB::commit();
          
          return response()->json([
              'ok' => true, 
              'data' => $codigo,
              'message' => "Se registro con exito el producto"
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
      $Producto = Producto::find($id);

          if ($Producto == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el producto"
            ]);
          }
      $Productos = Producto::select("producto.*")
      ->where("producto.id", $id)
      ->first();

      return response()->json([
        "ok" => true,
        "data" => $Productos
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
            'departamento' => 'required|max:4|string',
            'descripcion' => 'required|max:300|string',
            'enser' => 'required|numeric',
            'unidad' => 'required|numeric',
            'precio1' => 'required|numeric',          
            'precio2' => 'required|numeric',
            'precio3' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'imagen' => 'required|string',
            'estatus' => 'required|numeric',
            'tipo' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'ok' => false, 
              'error' => $validator->messages()
            ]);
        }

        try{

          $Producto = Producto::find($id);

          if ($Producto == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el producto"
            ]);
          }

          $Producto->update($input);
          DB::commit();

          return response()->json([
              'ok' => true, 
              'message' => "Se modifico el producto con exito"
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

          $Producto = Producto::findOrFail($id);

          if ($Producto == false) {
             return response()->json([
              'ok' => false, 
              'error' => "No se encontro el producto"
            ]);
          }

          $Producto = Producto::findOrFail($id)
          ->update(['estatus'=>'0']);
          
          return response()->json([
              'ok' => true, 
              'message' => "Se elimino el producto con exito"
            ]);

          }catch(\Exception $ex){
            
            return response()->json([
                'ok' => false, 
                'error' => $ex->getMessage()
            ]);
          }
    }
}
