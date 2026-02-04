<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    function run(): void {
        $tipos = ['Playa', 'Montaña', 'Ciudad', 'Aventura', 'Crucero', 'Rural'];

        foreach($tipos as $tipo) {
            DB::table("tipo")->insert([
                "nombre" => $tipo,
            ]);
        }
    }
}