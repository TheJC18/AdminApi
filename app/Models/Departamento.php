<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public $table = "departamento";

    protected $fillable = [
    	"codigo", 
    	"descripcion", 
        "estatus",
        "created_at",
    	"updated_at", 
    ];

}
