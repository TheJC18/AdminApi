<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
	public $table = "factura";

    protected $fillable = [
    	"codigo", 
    	"condicion", 
    	"porc_impuesto", 
    	"costo", 
    	"iva", 
    	"subtotal", 
    	"total", 
    	"observacion", 
    	"usuario", 
    	"estatus", 
    	"cod_cliente", 
		"etatus", 
		"created_at",
    	"updated_at",
    ];

    public function cliente(){  
        return $this->belongsTo(Cliente::class); 
	}

	public function usuario(){  
        return $this->belongsTo(Usuario::class); 
	}
	
	public function detallesfacturas(){  
    	return $this->hasMany(Detallefactura::class); 
	}
}
