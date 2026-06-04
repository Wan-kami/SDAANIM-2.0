<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

// Check if admin user exists
$admin = User::where('role', 'Administrador')->first();

if ($admin) {
    echo "Admin encontrado:\n";
    echo "Documento: " . $admin->Usu_documento . "\n";
    echo "Nombre: " . $admin->Usu_nombre . "\n";
    echo "Email: " . $admin->Usu_email . "\n";
} else {
    echo "No admin user found. Creating one...\n";
    
    $admin = User::create([
        'Usu_documento' => '1111111111',
        'Usu_nombre' => 'Administrador',
        'Usu_email' => 'admin@test.com',
        'Usu_telefono' => '1111111111',
        'Usu_password' => \Illuminate\Support\Facades\Hash::make('admin123'),
        'role' => 'Administrador',
        'Usu_estado' => 'Activo',
        'email_verified_at' => now(),
    ]);
    
    echo "Admin user created!\n";
    echo "Documento: 1111111111\n";
    echo "Password: admin123\n";
}
