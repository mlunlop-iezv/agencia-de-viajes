<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentario';
    protected $fillable = ['iduser', 'idvacacion', 'texto', 'estrellas'];

    function user(): BelongsTo {
        return $this->belongsTo('App\Models\User', 'iduser');
    }

    function vacacion(): BelongsTo {
        return $this->belongsTo('App\Models\Vacacion', 'idvacacion');
    }
}