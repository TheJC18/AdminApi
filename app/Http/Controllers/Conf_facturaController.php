<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_facturaController extends Controller
{
    public function getData(){
        return config("Conf_factura");
    }

    public function setData(Request $request){
        $config = new \App\Config("Conf_factura");
        $config->setMany(array(
            'num_factura' => $request->num_factura,
            'tipo_papel' => $request->tipo_papel,
            'margen_sup' => $request->margen_sup,
            'margen_inf' => $request->margen_inf,
            'margen_der' => $request->margen_der,
            'margen_izq' => $request->margen_izq,
            'inicial' => $request->inicial,
            'observacion' => $request->observacion,
         ));
         return response()->json([
            'message' => 'Funciono!'], 201);
    }
}
