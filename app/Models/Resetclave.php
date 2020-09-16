<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resetclave extends Model
{
    public $table = "resetclave";

    protected $fillable = [
    	"id_usuario", 
    	"nombre", 
    	"token", 
        "created_at",
    	"updated_at",
    ];

    public function usuario(){  
        return $this->belongsTo(Usuario::class); 
	}
}
