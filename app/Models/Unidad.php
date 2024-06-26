<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    public $table = "unidad";

    protected $fillable = [
    	"codigo", 
    	"descripcion", 
        "estatus", 
        "created_at",
    	"updated_at",
    ];

    public function productos(){  
    	return $this->hasMany(Producto::class); 
	}
}
