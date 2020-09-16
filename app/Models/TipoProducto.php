<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    public $table = "tipoproducto";

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
