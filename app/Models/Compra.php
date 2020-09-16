<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    public $table = "compra";

    protected $fillable = [
    	"codigo", 
    	"cod_documento", 
    	"num_control", 
    	"fecha_documento",
    	"sub_total",
    	"impuesto",
    	"total",
    	"nota",
    	"usuario",
    	"estatus",
		"cod_proveedor",
		"created_at",
    	"updated_at",
    ];

    public function proveedor(){  
        return $this->belongsTo(Proveedor::class); 
	}

	public function usuario(){  
        return $this->belongsTo(Usuario::class); 
	}
	
	public function detallescompras(){  
    	return $this->hasMany(Detallecompra::class); 
	}

	public function detallescotazaciones(){  
    	return $this->hasMany(Detallecotizacion::class); 
	}
}
