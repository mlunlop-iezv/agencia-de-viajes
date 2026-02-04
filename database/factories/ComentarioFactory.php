<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comentario;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    public function definition(): array
    {

        $comentarios = [
            '¡Una experiencia inolvidable! Repetiría sin dudarlo.',
            'El sitio es bonito, pero el viaje se hizo un poco largo.',
            'Increíble relación calidad-precio. Muy recomendado.',
            'No estuvo mal, pero esperaba algo más de organización.',
            'Simplemente mágico. Las vistas son espectaculares.',
            'Un desastre, llovió todo el tiempo y el guía no apareció.',
            'Todo perfecto, desde el hotel hasta las excursiones.',
            'Me encantó la comida local y la gente.',
        ];

        return [
            'texto' => $this->faker->randomElement($comentarios) . ' ' . $this->faker->sentence(),
            'estrellas' => $this->faker->numberBetween(1, 5),
        ];
    }
}