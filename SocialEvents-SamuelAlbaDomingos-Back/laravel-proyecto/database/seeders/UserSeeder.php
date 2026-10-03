<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Rol::where('nombre', 'admin')->firstOrFail();
        $userRole = Rol::where('nombre', 'usuario')->firstOrFail();

        $accounts = [
            [
                'email' => 'admin@example.com',
                'nombreUsuario' => 'admin_demo',
                'nombreCompleto' => 'Administrador StreetConnect',
                'localidadResidencia' => 'Gijón',
                'password' => env('SEED_ADMIN_PASSWORD', 'AdminDemo123!'),
                'rol_id' => $adminRole->id,
                'tag' => 'rap',
            ],
            [
                'email' => 'usuario@example.com',
                'nombreUsuario' => 'usuario_demo',
                'nombreCompleto' => 'Usuario de demostración',
                'localidadResidencia' => 'Gijón',
                'password' => env('SEED_USER_PASSWORD', 'UsuarioDemo123!'),
                'rol_id' => $userRole->id,
                'tag' => 'street-art',
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew(['email' => $account['email']]);
            $user->forceFill([
                'nombreCompleto' => $account['nombreCompleto'],
                'nombreUsuario' => $account['nombreUsuario'],
                'localidadResidencia' => $account['localidadResidencia'],
                'password' => Hash::make($account['password']),
                'rol_id' => $account['rol_id'],
                'estado' => 0,
            ])->save();

            $tag = Tag::where('slug', $account['tag'])->first();
            if ($tag) {
                $user->intereses()->syncWithoutDetaching([$tag->id]);
            }
        }
    }
}
