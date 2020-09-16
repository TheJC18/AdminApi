<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    public $table = "configuracion";

    protected $fillable = [
    	"descripcion", 
        "cod_usuario", 
        "created_at",
    	"updated_at",
    ];

    public function usuario(){  
        return $this->belongsTo(Usuario::class); 
    }
}
