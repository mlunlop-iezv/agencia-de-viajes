<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacacion extends Model
{
    use HasFactory;

    protected $table = 'vacacion';

    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'pais',
        'idtipo',
    ];

    function tipo(): BelongsTo
    {
        return $this->belongsTo('App\Models\Tipo', 'idtipo');
    }

    function fotos(): HasMany
    {
        return $this->hasMany('App\Models\Foto', 'idvacacion');
    }

    function comentarios(): HasMany
    {
        return $this->hasMany('App\Models\Comentario', 'idvacacion');
    }

    function reservas(): HasMany
    {
        return $this->hasMany('App\Models\Reserva', 'idvacacion');
    }

    function getPrimeraFoto(): string
    {
        $foto = $this->fotos->first();
        if ($foto != null) {
            if (str_starts_with($foto->ruta, 'http')) {
                return $foto->ruta;
            }
            return url('storage/' . $foto->ruta);
        }
        return url('assets/img/default.jpg');
    }
}