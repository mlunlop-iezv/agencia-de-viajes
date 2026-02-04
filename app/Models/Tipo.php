<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipo';
    public $timestamps = false; 
    protected $fillable = ['nombre'];

    function vacaciones(): HasMany {
        return $this->hasMany('App\Models\Vacacion', 'idtipo');
    }
}