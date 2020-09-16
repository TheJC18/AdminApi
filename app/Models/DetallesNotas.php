<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallesNotas extends Model
{
    public $table = "detallesnotas";

    protected $fillable = [
    	"nota", 
    	"cantidad", 
    	"precio", 
        "producto",
        "created_at",
    	"updated_at", 
    ];

    public function nota(){  
        return $this->belongsTo(Notasalida::class); 
    }

    public function producto(){  
        return $this->belongsTo(Producto::class); 
    }
}
