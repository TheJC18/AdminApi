<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_facturaController extends Controller
{
    public function getData(){
        $permiso = Auth::user()->hasPermissionTo('ver_facturac');
      if($permiso == '1'){
        return config("Conf_factura");
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function setData(Request $request){
        $permiso = Auth::user()->hasPermissionTo('crear_facturac');
      if($permiso == '1'){
        $config = new \App\Config("Conf_factura");
        $config->setMany(array(
            'num_factura' => $request->num_factura,
            'tipo_papel' => $request->tipo_papel,
            'margen_sup' => $request->margen_sup,
            'margen_inf' => $request->margen_inf,
            'margen_der' => $request->margen_der,
            'margen_izq' => $request->margen_izq,
            'inicial' => $request->inicial,-
            'observacion' => $request->observacion,
         ));
         return response()->json([
            'message' => 'Funciono!'], 201);
      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }
}
