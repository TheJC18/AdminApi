<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
	public $table = "producto";

    protected $fillable = [
    	"codigo", 
    	"departamento", 
    	"descripcion", 
    	"enser", 
    	"unidad", 
    	"precio1", 
    	"precio2", 
    	"precio3", 
    	"imagen", 
    	"estatus", 
    	"cantitdad", 
		"tipo", 
		"created_at",
    	"updated_at",
    ];

    public function tipo(){  
        return $this->belongsTo(TipoProducto::class); 
	}

	public function unidad(){  
        return $this->belongsTo(Unidad::class); 
	}

    public function detallesajustes(){  
    	return $this->hasMany(Detallesajusteinv::class); 
	}

	public function detallescompras(){  
    	return $this->hasMany(Detallecompra::class); 
	}

	public function detallescotazaciones(){  
    	return $this->hasMany(Detallecotizacion::class); 
	}

	public function detallesfacturas(){  
    	return $this->hasMany(Detallefactura::class); 
	}

	public function detallesordencompras(){  
    	return $this->hasMany(Detalleordencompra::class); 
	}

	public function detallesnotas(){  
    	return $this->hasMany(Detallesnotas::class); 
	}
}
