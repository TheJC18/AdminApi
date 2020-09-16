<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajusteinv extends Model
{
    public $table = "ajusteinv";

    protected $fillable = [
    	"codigo", 
    	"tipo_ajuste", 
    	"nota", 
    	"fecha", 
		"usuario",
		"created_at",
    	"updated_at",
	];
	
	public function usuario(){  
        return $this->belongsTo(Usuario::class); 
    }
}
