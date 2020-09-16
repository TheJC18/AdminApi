<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
	public $table = "proveedor";

    protected $fillable = [
    	"codigo", 
    	"nombre", 
    	"correo", 
    	"direccion", 
    	"contacto", 
    	"telefono", 
		"estatus", 
		"created_at",
    	"updated_at",
    ];

    public function compras(){  
    	return $this->hasMany(Compra::class); 
	}

	public function ordencompras(){  
    	return $this->hasMany(Ordencompra::class); 
	}
}
