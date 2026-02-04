<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacacionCreateRequest extends FormRequest
{
    function attributes(): array {
        return [
            'titulo' => 'título de la vacación',
            'descripcion' => 'descripción',
            'precio' => 'precio',
            'pais' => 'país',
            'idtipo' => 'tipo de vacación',
        ];
    }

    function authorize(): bool {
        return true;
    }

    function messages(): array {
        $max = 'El campo :attribute no puede tener más de :max caracteres.';
        $min = 'El campo :attribute no puede tener menos de :min caracteres.';
        $required = 'El campo :attribute es obligatorio.';
        $numeric = 'El campo :attribute debe ser numérico.';
        
        return [
            'titulo.required'  => $required,
            'titulo.min'       => $min,
            'titulo.max'       => $max,
            'descripcion.required' => $required,
            'precio.required'  => $required,
            'precio.numeric'   => $numeric,
            'pais.required'    => $required,
            'idtipo.required'  => $required,
        ];
    }

    function rules(): array {
        return [
            'titulo'      => 'required|min:4|max:100|string',
            'descripcion' => 'required|min:10',
            'precio'      => 'required|numeric|min:0',
            'pais'        => 'required|min:2|max:100',
            'idtipo'      => 'required|exists:tipo,id',
        ];
    }
}