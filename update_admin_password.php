<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Update admin password
$admin = User::where('Usu_documento', '1000000000')->first();

if ($admin) {
    $admin->update(['Usu_password' => Hash::make('admin123')]);
    echo "Admin password updated!\n";
    echo "Documento: 1000000000\n";
    echo "Password: admin123\n";
} else {
    echo "Admin not found\n";
}
