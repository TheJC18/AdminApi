<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detallefactura extends Model
{
    public $table = "detallefactura";

    protected $fillable = [
    	"precio_unit", 
    	"cantidad", 
    	"monto", 
    	"codFactura", 
        "codProducto", 
        "created_at",
    	"updated_at",
    ];

    public function factura(){  
        return $this->belongsTo(Factura::class); 
    }

    public function producto(){  
        return $this->belongsTo(Producto::class); 
    }

}
