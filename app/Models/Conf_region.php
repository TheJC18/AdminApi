<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conf_region extends Model
{
    protected $fillable = [
    	"codigo_fiscal", 
    	"moneda", 
    	"impuesto", 
    	"imp_esp", 
    	"impuesto1", 
    	"monto1", 
    	"impuesto2", 
    	"monto2", 
    ];
}
