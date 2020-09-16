<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmp_cotizacion extends Model
{
    public $table = "tmp_cotizacion";

    protected $fillable = [
    	"codigo", 
    	"fecha", 
    	"iva", 
    	"subtotal", 
    	"total", 
    	"forma_pago", 
    	"tiempo_entrega", 
    	"validez", 
    	"nota", 
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

}
