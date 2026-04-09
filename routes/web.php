<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Animal;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\InscriptionController;

// --- GUEST / PUBLIC ROUTES ---
Route::get('/', function () {
    $animals = Animal::latest()->take(6)->get();
    return view('welcome', compact('animals'));
})->name('welcome');

Route::get('/quienes-somos', function () {
    return view('public.about');
})->name('about');
Route::get('/adopta', [AnimalController::class, 'publicIndex'])->name('adopta');
Route::get('/animal/{id}', [AnimalController::class, 'show'])->name('animal.show');
Route::get('/api/animal/{id}/medical-history', [AnimalController::class, 'getMedicalHistory'])->name('animal.medical-history');
Route::get('/productos', [ProductController::class, 'publicIndex'])->name('products.public');
Route::get('/contacto', function () {
    return view('public.contact');
})->name('contact');

Route::get('/voluntario', [InscriptionController::class, 'createVolunteer'])->name('inscriptions.volunteer');
Route::get('/veterinario', [InscriptionController::class, 'createVeterinarian'])->name('inscriptions.veterinarian');
Route::post('/inscripciones', [InscriptionController::class, 'store'])->name('inscriptions.store');

// --- AUTHENTICATION ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/password/forgot', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetCode'])->name('password.forgot');
Route::post('/password/verify-code', [App\Http\Controllers\Auth\PasswordResetController::class, 'verifyResetCode'])->name('password.verify');
Route::post('/password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.reset');

Route::get('/registrar', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/registrar', [RegisterController::class, 'register'])->name('register.custom');
Route::get('/verificar', function () {
    return view('auth.verify');
})->name('verify');

Route::post('/verificar', [RegisterController::class, 'verificarCodigo'])->name('verify.code');

// --- PROTECTED ROUTES (AUTH) ---
Route::middleware(['auth'])->group(function () {

    // PROFILE
    Route::get('/mi-perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mi-perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/mi-perfil/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/mi-perfil/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');

    // REDIRECTION ROUTE (Universal Dashboard)
    Route::get('/dashboard', function () {
        return match (Auth::user()->role) {
            'Voluntario' => redirect()->route('volunteer.dashboard'),
            'Veterinario' => redirect()->route('vet.dashboard'),
            'Adoptante' => redirect()->route('adopter.dashboard'),
            default => redirect('/'),
        };
    })->name('dashboard');

    // ADOPTER PANEL
    Route::prefix('adopter')->name('adopter.')->group(function () {
        Route::get('/dashboard', [AnimalController::class, 'adopterDashboard'])->name('dashboard');
        Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile');
        Route::post('/perfil', [ProfileController::class, 'update']);
        Route::get('/mis-solicitudes', [AdoptionController::class, 'userRequests'])->name('requests');
        Route::get('/solicitar-adopcion/{animal_id}', [AdoptionController::class, 'create'])->name('adoption.create');
        Route::post('/solicitar-adopcion', [AdoptionController::class, 'store'])->name('adoption.store');
        Route::get('/donar', [DonationController::class, 'create'])->name('donation.create');
        Route::post('/donar', [DonationController::class, 'store'])->name('donation.store');
    });

    // CART ROUTES (all authenticated users)
    Route::prefix('carrito')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'view'])->name('view');
        Route::post('/agregar/{prod_id}', [CartController::class, 'add'])->name('add');
        Route::delete('/remover/{cart_id}', [CartController::class, 'remove'])->name('remove');
        Route::post('/actualizar-cantidad/{cart_id}', [CartController::class, 'updateQuantity'])->name('update-quantity');
        Route::post('/vaciar', [CartController::class, 'clear'])->name('clear');
    });

    // ORDERS ROUTES
    Route::prefix('pedidos')->name('orders.')->group(function () {
        Route::post('/confirmar', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/{ord_id}', [OrderController::class, 'show'])->name('show');
        Route::get('/', [OrderController::class, 'history'])->name('history');
    });

    // VOLUNTEER PANEL
    Route::prefix('volunteer')->name('volunteer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('home.volunteer');
        })->name('dashboard');
        Route::get('/tareas', [TaskController::class, 'index'])->name('tasks');
        Route::get('/progreso', [TaskController::class, 'volunteerProgress'])->name('progress');

        // Actualizar estado de la tarea
        Route::patch('/tareas/{id}/estado', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

        // Completar tarea (con comentario)
        Route::post('/tareas/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
        Route::post('/tareas/{id}/comentar', [TaskController::class, 'updateComment'])->name('tasks.updateComment');

        // Availability
        Route::get('/disponibilidad', [AvailabilityController::class, 'index'])->name('availability');
        Route::post('/disponibilidad', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/disponibilidad/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
    });

    // VET PANEL
    Route::prefix('vet')->name('vet.')->group(function () {
        Route::get('/dashboard', function () {
            return view('home.vet');
        })->name('dashboard');
        Route::get('/animales', [AnimalController::class, 'index'])->name('animals');
        Route::get('/historial/{animal_id}', [MedicalHistoryController::class, 'index'])->name('history');
        Route::post('/historial', [MedicalHistoryController::class, 'store'])->name('history.store');

        // Vet tasks (tareas asignadas)
        Route::get('/tareas', [TaskController::class, 'index'])->name('tasks');
        Route::get('/progreso', [TaskController::class, 'volunteerProgress'])->name('progress');
        Route::patch('/tareas/{id}/estado', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
        Route::post('/tareas/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
        Route::post('/tareas/{id}/comentar', [TaskController::class, 'updateComment'])->name('tasks.updateComment');

        // Availability
        Route::get('/disponibilidad', [AvailabilityController::class, 'index'])->name('availability');
        Route::post('/disponibilidad', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/disponibilidad/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
    });

    Route::post('/notificaciones/leer', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notificaciones.leer');
    Route::get('/notifications', function () {
        $notifications = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
            ->latest('Noti_fecha')
            ->get();
        return view('notifications.index', compact('notifications'));
    })->name('notifications');

    Route::delete('/notifications/{id}', function ($id) {
        $notification = \App\Models\Notification::where('Noto_id', $id)
            ->where('Usu_documento', Auth::user()->Usu_documento)
            ->firstOrFail();
        $notification->delete();
        return back()->with('success', 'Notificación eliminada.');
    })->name('notifications.delete');
});
