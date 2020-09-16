<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    public $table = "cotizacion";

    protected $fillable = [
    	"codigo", 
    	"iva", 
    	"subtotal", 
    	"total", 
    	"forma_pago", 
    	"tiempo_entrega", 
    	"validez", 
    	"nota", 
    	"tasa", 
    	"estatus", 
    	"usuario", 
		"cod_cliente", 
		"created_at",
    	"updated_at",
    ];

    public function cliente(){  
        return $this->belongsTo(Cliente::class); 
	}
	
	public function usuario(){  
        return $this->belongsTo(Usuario::class); 
    }

    public function seguimientos(){  
    	return $this->hasMany(Cotizacion_seguimiento::class); 
	}
}
