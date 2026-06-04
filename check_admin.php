<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

// Get all admin users
$admins = User::where('role', 'Administrador')->get();

echo "Usuarios Administradores:\n";
foreach ($admins as $admin) {
    echo "Documento: " . $admin->Usu_documento . "\n";
    echo "Nombre: " . $admin->Usu_nombre . "\n";
    echo "Email: " . $admin->Usu_email . "\n";
    echo "Estado: " . $admin->Usu_estado . "\n";
    echo "---\n";
}

// Test password
echo "\nTesting login with 1000000000...\n";
$user = User::where('Usu_documento', '1000000000')->first();
if ($user) {
    echo "User found: " . $user->Usu_nombre . "\n";
    $password = 'admin123';
    if (\Illuminate\Support\Facades\Hash::check($password, $user->Usu_password)) {
        echo "Password is correct!\n";
    } else {
        echo "Password is INCORRECT\n";
        echo "Password hash in DB: " . $user->Usu_password . "\n";
        // Update password
        $user->update(['Usu_password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        echo "Password updated!\n";
    }
} else {
    echo "User not found\n";
}
