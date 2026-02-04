<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'texto'      => 'required|string|min:3|max:500',
            // El viaje tiene que existir en la BD
            'idvacacion' => 'required|exists:vacacion,id',
            // Rating de 1 a 5 estrellas
            'estrellas'  => 'required|integer|min:1|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'texto.required' => 'El comentario no puede estar vacío.',
            'texto.min'      => 'El comentario es muy corto.',
        ];
    }
}