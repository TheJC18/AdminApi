<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    public $table = "moneda";

    protected $fillable = [
    	"descripcion", 
        "estatus", 
        "created_at",
    	"updated_at",
    ];
}
