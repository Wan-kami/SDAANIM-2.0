<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'Usu_documento' => 8754569,
                'name' => 'Alfredo Vergel',
                'email' => 'alfreditovergel@gmail.com',
                'Usu_telefono' => '3004776275',
                'role' => 'Voluntario',
                'Usu_direccion' => 'San Antonio',
                'password' => Hash::make('12345678'),
                'status' => 'Activo',
            ],
            [
                'Usu_documento' => 1044611304,
                'name' => 'Marcela SS',
                'email' => 'linamseguras@gmail.com',
                'Usu_telefono' => '3145800390',
                'role' => 'Adoptante',
                'Usu_direccion' => 'Los Campanos II',
                'password' => Hash::make('12345678'),
                'status' => 'Activo',
            ],
            [
                'Usu_documento' => 1130273716,
                'name' => 'Sofia SS',
                'email' => 'alejasseguras@gmail.com',
                'Usu_telefono' => '3174635797',
                'role' => 'Voluntario',
                'Usu_direccion' => 'Los Campanos II',
                'password' => Hash::make('12345678'),
                'status' => 'Activo',
            ],
            [
                'Usu_documento' => 3254687,
                'name' => 'Roberto Diaz',
                'email' => 'roberto.vet@gmail.com',
                'Usu_telefono' => '3209876543',
                'role' => 'Veterinario',
                'Usu_direccion' => 'Avenida Siempre Viva',
                'password' => Hash::make('12345678'),
                'status' => 'Activo',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(['Usu_documento' => $userData['Usu_documento']], $userData);
        }
    }
}
