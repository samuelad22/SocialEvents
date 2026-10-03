<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Database\Seeder;

class ValoracionSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = User::where('email', 'usuario@example.com')->firstOrFail();
        $evento = Evento::where('slug', 'batalla-de-gallos')->firstOrFail();

        Valoracion::updateOrCreate(
            ['user_id' => $usuario->id, 'evento_id' => $evento->id],
            [
                'puntuacion' => 5,
                'fecha' => now(),
                'contenido' => 'Gran ambiente urbano para probar la plataforma.',
            ]
        );
    }
}
