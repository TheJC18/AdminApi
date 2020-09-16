<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detallecotizacion extends Model
{
    public $table = "detallecotizacion";

    protected $fillable = [
    	"precio_unit", 
    	"cantidad", 
    	"monto", 
    	"codCotizacion", 
        "codProducto",
        "created_at",
    	"updated_at", 
    ];

    public function producto(){  
        return $this->belongsTo(Producto::class); 
    }

    public function cotizacion(){  
        return $this->belongsTo(Cotizacion::class); 
    }
}
