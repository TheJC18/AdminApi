<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conf_factura extends Model
{
    protected $fillable = [
    	"num_factura", 
    	"tipo_papel", 
    	"margen_sup", 
    	"margen_inf", 
    	"margen_der", 
    	"margen_izq", 
    	"inicial",
    	"observacion",
    ];
}
