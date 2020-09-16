<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conf_empresa extends Model
{

    protected $fillable = [
    	"nombre", 
    	"numero_fiscal", 
    	"direccion", 
    	"telefono",
    	"correo",
    	"web",
    	"pago",
    	"logon",
    	"eslogan",
    ];
}
