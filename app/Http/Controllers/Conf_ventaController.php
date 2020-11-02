<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_ventaController extends Controller
{
    public function getData(){
        $permiso = Auth::user()->hasPermissionTo('ver_venta');
      if($permiso == '1'){
       
        return config("Conf_venta");

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function setData(Request $request){
        $permiso = Auth::user()->hasPermissionTo('crear_venta');
      if($permiso == '1'){

        $config = new \App\Config("Conf_venta");
        $config->setMany(array(
            'garantia' => $request->garantia,
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
