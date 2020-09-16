<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_regionController extends Controller
{
    public function getData(){
        return config("Conf_region");
    }

    public function setData(Request $request){
        $config = new \App\Config("Conf_region");
        $config->setMany(array(
            'codigo_fiscal' => $request->codigo_fiscal,
            'moneda' => $request->moneda,
            'impuesto' => $request->impuesto,
            'imp_esp' => $request->imp_esp,
            'impuesto1' => $request->impuesto1,
            'monto1' => $request->monto1,
            'impuesto2' => $request->impuesto2,
            'monto2' => $request->monto2,
         ));
         return response()->json([
            'message' => 'Funciono!'], 201);
    }
}
