<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detallecompra extends Model
{
    public $table = "detallecompra";

    protected $fillable = [
    	"precio_unit", 
    	"cantidad", 
    	"monto", 
    	"cod_compra", 
        "cod_producto",
        "created_at",
    	"updated_at", 
    ];

    public function producto(){  
        return $this->belongsTo(Producto::class); 
    }

    public function compra(){  
        return $this->belongsTo(Compra::class); 
    }
}
