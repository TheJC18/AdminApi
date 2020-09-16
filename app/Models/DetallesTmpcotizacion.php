<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallesTmpcotizacion extends Model
{
    public $table = "detalles_tmpcotizacions";

    protected $fillable = [
    	"cantidad", 
    	"monto", 
    	"codTmpcotizacion", 
    	"precio_unit", 
        "codProducto", 
        "created_at",
    	"updated_at",
    ];

    public function tmpcotizacion(){  
        return $this->belongsTo(Tmp_cotizacion::class); 
    }

    public function producto(){  
        return $this->belongsTo(Producto::class); 
    }
}
