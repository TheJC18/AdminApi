<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenSeguimiento extends Model
{
    public $table = "orden_seguimiento";

    protected $fillable = [
    	"descripcion", 
    	"usuario", 
        "cod_orden", 
        "created_at",
    	"updated_at",
    ];

    public function ordencompra(){  
        return $this->belongsTo(Ordencompa::class); 
    }
    
    public function usuario(){  
        return $this->belongsTo(Usuario::class); 
	}
}
