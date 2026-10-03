<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->firstOrFail();
        $events = [
            ['nombre' => 'Batalla de Gallos', 'categoria_id' => 3, 'aforoMaximo' => 120, 'tags' => [1]],
            ['nombre' => 'Jam de Graffiti Primavera', 'categoria_id' => 1, 'aforoMaximo' => 80, 'tags' => [2]],
            ['nombre' => 'Street Basketball 3x3', 'categoria_id' => 2, 'aforoMaximo' => 40, 'tags' => [3]],
            ['nombre' => 'Demo: Lista de espera', 'categoria_id' => 3, 'aforoMaximo' => 1, 'tags' => [1]],
        ];

        foreach ($events as $event) {
            $slug = Str::slug($event['nombre']);
            $evento = Evento::updateOrCreate(
                ['slug' => $slug],
                [
                    'nombre' => $event['nombre'],
                    'ubicacion' => 'Plaza Mayor, Gijón, Asturias, España',
                    'aforoMaximo' => $event['aforoMaximo'],
                    'aforoActual' => $slug === 'demo-lista-de-espera' ? 1 : 0,
                    'fechaInicio' => now()->addMonth()->toDateString(),
                    'fechaFin' => now()->addMonth()->toDateString(),
                    'horaInicio' => '18:00:00',
                    'horaFin' => '21:00:00',
                    'imagen' => 'imagenes/'.$slug.'.png',
                    'descripcion' => 'Evento de demostración de cultura urbana para probar StreetConnect.',
                    'categoria_id' => $event['categoria_id'],
                    'creador_id' => $admin->id,
                    'precio' => 0,
                    'dineroGenerado' => 0,
                ]
            );
            $evento->tags()->sync($event['tags']);
        }

        $demo = Evento::where('slug', 'demo-lista-de-espera')->firstOrFail();
        $usuario = User::where('email', 'usuario@example.com')->firstOrFail();
        DB::table('inscripciones')->updateOrInsert(
            ['evento_id' => $demo->id, 'user_id' => $usuario->id],
            [
                'acompañantes' => 0,
                'email' => $usuario->email,
                'qr_usado' => false,
                'mensaje' => 'Inscripción de demostración',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
