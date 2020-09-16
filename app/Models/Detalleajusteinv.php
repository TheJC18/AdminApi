<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleajusteinv extends Model
{
    public $table = "detalleajusteinv";

    protected $fillable = [
    	"descripcion", 
    	"cantidad", 
    	"cod_ajuste", 
        "cod_producto",
        "created_at",
    	"updated_at", 
    ];

    public function producto(){  
        return $this->belongsTo(Producto::class); 
    }

    public function ajuste(){  
        return $this->belongsTo(Ajusteinv::class); 
    }
}
