<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{

    private $categorias = [
        [
            'nombre' => 'Arte',
            'color'=> 'purple',
            'descripcion'=> 'Multiples eventos enfocados en el arte visual',
            
            ],
        [
            'nombre' => 'Deporte',
            'color'=> 'yellow',
            'descripcion' => 'Multiples eventos enfocados en la actividad fisica'
        ],
        [
            'nombre'=> 'Musica',
            'color'=> 'cyan',
            'descripcion'=> 'Multiples eventos enfocados en mucha varidad musical'
        ]
    ];

    public function run(): void {
        foreach($this->categorias as $categoria){
            Categoria::updateOrCreate(
                ['nombre' => $categoria['nombre']],
                [
                    'slug' => Str::slug($categoria['nombre']),
                    'descripcion' => $categoria['descripcion'],
                    'color' => $categoria['color'],
                ]
            );
        }
    }
}
