<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_regionController extends Controller
{
    public function getData(){
        $permiso = Auth::user()->hasPermissionTo('ver_region');
      if($permiso == '1'){

        return config("Conf_region");
    
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function setData(Request $request){
        $permiso = Auth::user()->hasPermissionTo('crear_region');
      if($permiso == '1'){
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
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }
}
