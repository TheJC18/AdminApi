<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MejorMes extends Model
{
    public $table = "mejor_mes";

    protected $fillable = [
    	"ventas", 
    	"mes", 
        "año", 
        "created_at",
    	"updated_at",
    ];
}
