<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vacacion;
use App\Models\Tipo;

class VacacionFactory extends Factory
{
    protected $model = Vacacion::class;

    public function definition(): array {
        return [
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraphs(2, true),
            'precio' => $this->faker->randomFloat(2, 100, 5000),
            'pais' => $this->faker->country(),
            'idtipo' => Tipo::inRandomOrder()->first()->id,
        ];
    }
}