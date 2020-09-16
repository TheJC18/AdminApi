<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionSeguimiento extends Model
{
    public $table = "cotizacion_seguimiento";

    protected $fillable = [
    	"descripcion", 
    	"cod_cotizacion", 
        "usuario",
        "created_at",
    	"updated_at", 
    ];

    public function cotizacion(){  
        return $this->belongsTo(Cotizacion::class); 
    }

    public function usuario(){  
        return $this->belongsTo(Usuario::class); 
    }
}
