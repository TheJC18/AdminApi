<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_ventaController extends Controller
{
    public function getData(){
        return config("Conf_venta");
    }

    public function setData(Request $request){
        $config = new \App\Config("Conf_venta");
        $config->setMany(array(
            'garantia' => $request->garantia,
            'observacion' => $request->observacion,
         ));
         return response()->json([
            'message' => 'Funciono!'], 201);
    }
}
