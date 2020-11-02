<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Conf_empresaController extends Controller
{
    public function getData(){
    $permiso = Auth::user()->hasPermissionTo('ver_empresa');
      if($permiso == '1'){

        return config("Conf_empresa");

      }else{
        return response()->json([
          'message' => 'No tiene permisos para accerder a esta funcion'], 403);
      }
    }

    public function setData(Request $request){
        $permiso = Auth::user()->hasPermissionTo('crear_empresa');
        if($permiso == '1'){
  
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
    
        }else{
          return response()->json([
            'message' => 'No tiene permisos para accerder a esta funcion'], 403);
        }    
    }

}
