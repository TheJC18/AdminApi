<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleordencompra extends Model
{
    public $table = "detalleordencompra";

    protected $fillable = [
    	"precio_unit", 
    	"cantidad", 
    	"monto", 
    	"cod_orden", 
        "cod_producto",
        "created_at",
    	"updated_at", 
    ];

    public function ordencompra(){  
        return $this->belongsTo(Ordencompra::class); 
    }

    public function producto(){  
        return $this->belongsTo(Producto::class); 
    }

}
