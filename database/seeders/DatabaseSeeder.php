<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vacacion;
use App\Models\Foto;
use App\Models\Reserva;
use App\Models\Comentario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'rol' => 'admin'
        ]);

        // 1.5 Crear Usuario Mario
        User::create([
            'name' => 'Mario Luna',
            'email' => 'mario.luna.lpez@gmail.com', 
            'password' => Hash::make('password'),
            'email_verified_at' => null, 
            'rol' => 'user'
        ]);

        // 2. Crear 20 Usuarios normales adicionales
        $users = User::factory(20)->create();

        // 3. Crear Tipos de Viaje
        $this->call(TipoSeeder::class);

        // 4. Crear 15 Vacaciones
        $vacaciones = Vacacion::factory(15)->create();

        // 5. Lógica para Fotos, Reservas y Comentarios
        foreach ($vacaciones as $vacacion) {
            
            // A. Añadir 2 fotos aleatorias a cada viaje 
            Foto::factory(2)->create([
                'idvacacion' => $vacacion->id
            ]);

            // B. Seleccionar entre 1 y 5 usuarios al azar para que comenten este viaje
            $randomUsers = $users->random(rand(1, 5));

            foreach ($randomUsers as $user) {
                // PRIMERO: Creamos la Reserva 
                Reserva::create([
                    'iduser' => $user->id,
                    'idvacacion' => $vacacion->id,
                    'created_at' => now()->subDays(rand(1, 30)) 
                ]);

                // SEGUNDO: Creamos el Comentario asociado
                Comentario::factory()->create([
                    'iduser' => $user->id,
                    'idvacacion' => $vacacion->id,
                ]);
            }
        }
    }
}