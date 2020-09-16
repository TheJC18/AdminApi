<?php

namespace App\Models;

use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Model;

class Dolar extends Model
{    
    use SoftDeletes;

    public $table = "dolares";

    protected $fillable = [
    	"monto", 
        "created_at",
    	"updated_at",
    ];

    public function cotizacion(){  
    	return $this->hasMany(Cotizacion::class); 
	}
}
