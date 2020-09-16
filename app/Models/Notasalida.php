<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notasalida extends Model
{
    public $table = "notasalida";

    protected $fillable = [
    	"codigo", 
    	"total", 
    	"nota", 
    	"usuario", 
    	"estatus", 
		"cod_cliente",
		"created_at",
    	"updated_at", 
    ];

    public function cliente(){  
        return $this->belongsTo(Cliente::class); 
	}

	public function usuario(){  
        return $this->belongsTo(Usuario::class); 
	}
}
