<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordencompra extends Model
{
    public $table = "ordencompra";

    protected $fillable = [
    	"codigo", 
    	"subtotal", 
    	"impuesto", 
    	"total", 
    	"forma_pago", 
    	"tiempo_entrega", 
    	"validez", 
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

	public function ordenesseguimiento(){  
    	return $this->hasMany(OrdenSeguimiento::class); 
	}

    public function detallesordencompras(){  
    	return $this->hasMany(Detalleordencompra::class); 
	}
}
