<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $table = "cliente";

    protected $fillable = [
    	"codigo", 
    	"nombre", 
    	"correo", 
    	"direccion", 
    	"contacto",
    	"telefono",
    	"tipo_contribuyente",
    	"retencion",
		"estatus",
		"created_at",
    	"updated_at",
    ];

    public function cotizaciones(){  
    	return $this->hasMany(Cotizacion::class); 
	}

	public function notassalida(){  
    	return $this->hasMany(Notasalida::class); 
	}

	public function tmp_cotizaciones(){  
    	return $this->hasMany(Tmp_cotizacion::class); 
	}
}
