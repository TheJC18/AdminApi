<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_empresaController extends Controller
{
    public function getData(){
        return config("Conf_empresa");
    }

    public function setData(Request $request){
        $config = new \App\Config("Conf_empresa");
        $config->setMany(array(
            'nombre' => $request->nombre,
            'numero_fiscal' => $request->numero_fiscal,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'web' => $request->web,
            'eslogan' => $request->eslogan,
            'logo' => $request->logo,
            'pago' => $request->pago,
         ));
         return response()->json([
            'message' => 'Funciono!'], 201);
    }

}
