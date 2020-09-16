<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equilibrio extends Model
{
    public $table = "equilibrio";

    protected $fillable = [
    	"codigo", 
    	"ano", 
    	"mes", 
		"monto", 
		"created_at",
    	"updated_at",
    ];

}
