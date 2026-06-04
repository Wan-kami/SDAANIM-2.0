<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

// --- GUEST / PUBLIC ROUTES ---
Route::get('/', function () {
    $animals = Animal::where('Anim_estado', '!=', 'Adoptado')->latest()->take(6)->get();
    return view('welcome', compact('animals'));
})->name('welcome');

Route::get('/quienes-somos', function () {
    if (!Schema::hasTable('quienes_somos')) {
        $about = (object) [
            'mision' => 'Proteger y cuidar animales en situación de vulnerabilidad.',
            'vision' => 'Ser un refugio modelo en la protección animal.',
            'valores' => ['Compasión', 'Responsabilidad', 'Dedicación'],
        ];

        return view('public.about', compact('about'));
    }

    $about = \App\Models\AboutPage::first();
    if (!$about) {
        $about = \App\Models\AboutPage::create([
            'mision' => 'Proteger y cuidar animales en situación de vulnerabilidad.',
            'vision' => 'Ser un refugio modelo en la protección animal.',
            'valores' => json_encode(['Compasión', 'Responsabilidad', 'Dedicación']),
        ]);
    }
    return view('public.about', compact('about'));
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

Route::get('/comunidad', [App\Http\Controllers\ReviewController::class, 'publicIndex'])->name('social');
Route::get('/modelo-negocio', function () {
    return view('public.business'); 
})->name('business');
Route::get('/concientizacion', function () {
    return view('public.awareness'); 
})->name('awareness');

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
            'Administrador' => redirect()->route('admin.dashboard'),
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
        Route::post('/mis-solicitudes/{soli_id}/calificar', [App\Http\Controllers\ReviewController::class, 'store'])->name('adoptions.review');
        
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
        Route::get('/dashboard', [DashboardController::class, 'volunteerDashboard'])->name('dashboard');
        Route::get('/tareas', [TaskController::class, 'index'])->name('tasks');
        Route::get('/progreso', [TaskController::class, 'volunteerProgress'])->name('progress');

        // Actualizar estado de la tarea
        Route::patch('/tareas/{id}/estado', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

        // Completar tarea (con comentario)
        Route::post('/tareas/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
        Route::post('/tareas/{id}/comentar', [TaskController::class, 'updateComment'])->name('tasks.updateComment');
    });

    // VET PANEL
    Route::prefix('vet')->name('vet.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'vetDashboard'])->name('dashboard');
        Route::get('/animales', [AnimalController::class, 'index'])->name('animals');
        Route::get('/historial/{animal_id}', [MedicalHistoryController::class, 'index'])->name('history');
        Route::post('/historial', [MedicalHistoryController::class, 'store'])->name('history.store');

        // Vet tasks (tareas asignadas)
        Route::get('/tareas', [TaskController::class, 'index'])->name('tasks');
        Route::get('/progreso', [TaskController::class, 'volunteerProgress'])->name('progress');
        Route::patch('/tareas/{id}/estado', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
        Route::post('/tareas/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
        Route::post('/tareas/{id}/comentar', [TaskController::class, 'updateComment'])->name('tasks.updateComment');
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

    // PROFILE ROUTES
    Route::get('/perfil', function () {
        return view('profile.show');
    })->name('profile.show');

    // Public listing routes removed from here as they are now public

    // ADMIN PANEL0
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Animals CRUD
        Route::get('/animals', [AdminController::class, 'animals'])->name('animals');
        Route::get('/animals/create', [AdminController::class, 'createAnimal'])->name('animals.create');
        Route::post('/animals', [AdminController::class, 'storeAnimal'])->name('animals.store');
        Route::get('/animals/{id}/edit', [AdminController::class, 'editAnimal'])->name('animals.edit');
        Route::put('/animals/{id}', [AdminController::class, 'updateAnimal'])->name('animals.update');
        Route::delete('/animals/{id}', [AdminController::class, 'destroyAnimal'])->name('animals.destroy');

        // Products CRUD
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

        // Product Colors
        Route::post('/products/{id}/colors', [AdminController::class, 'addColor'])->name('colors.add');
        Route::delete('/colors/{id}', [AdminController::class, 'deleteColor'])->name('colors.delete');

        // Product Sizes
        Route::post('/products/{id}/sizes', [AdminController::class, 'addSize'])->name('sizes.add');
        Route::delete('/sizes/{id}', [AdminController::class, 'deleteSize'])->name('sizes.delete');

        // Appointments
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
        Route::post('/appointments', [AdminController::class, 'storeAppointment'])->name('appointments.store');
        Route::put('/appointments/{id}/status', [AdminController::class, 'updateAppointmentStatus'])->name('appointments.updateStatus');

        // About Page
        Route::get('/about', [AdminController::class, 'about'])->name('about');
        Route::put('/about', [AdminController::class, 'updateAbout'])->name('about.update');

        // Users Management
        Route::get('/adoptants', [AdminController::class, 'adoptants'])->name('adoptants');
        Route::put('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
        Route::put('/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
        Route::put('/users/{id}/activate', [AdminController::class, 'activateUser'])->name('users.activate');

        // Veterinarians (inscriptions)
        Route::get('/veterinarians', [AdminController::class, 'veterinarians'])->name('veterinarians');
        Route::post('/veterinarians/process', [AdminController::class, 'processVeterinarian'])->name('veterinarians.process');

        // Volunteers (inscriptions)
        Route::get('/volunteers', [AdminController::class, 'volunteers'])->name('volunteers');
        Route::post('/volunteers/process', [AdminController::class, 'processVolunteer'])->name('volunteers.process');

        // Adoptions
        Route::get('/adoptions', [AdminController::class, 'adoptions'])->name('adoptions');
        Route::get('/adoptions/all', [AdminController::class, 'allAdoptions'])->name('adoptions.all');
        Route::get('/adoptions/{id}', [AdminController::class, 'showAdoption'])->name('adoptions.show');
        Route::get('/adoptions/{id}/assign', [AdminController::class, 'showAssignVolunteer'])->name('adoptions.assign');
        Route::post('/adoptions/assign', [AdminController::class, 'assignVolunteer'])->name('adoptions.assign.store');
        Route::get('/adoptions/{id}/approve', [AdminController::class, 'approveAdoption'])->name('adoptions.approve');
        Route::get('/adoptions/{id}/reject', [AdminController::class, 'rejectAdoption'])->name('adoptions.reject');
        Route::post('/adoptions/{id}/report', [AdoptionController::class, 'submitReport'])->name('adoptions.report');

        // Followups
        Route::get('/adoptions/{soliId}/followup', [AdminController::class, 'createFollowup'])->name('adoptions.followup.create');
        Route::post('/adoptions/{soliId}/followup', [AdminController::class, 'storeFollowup'])->name('adoptions.followup.store');

        // Orders
        Route::get('/pedidos', [AdminController::class, 'orders'])->name('orders');
        Route::get('/pedidos/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
        Route::post('/pedidos/{id}/recogido', [AdminController::class, 'markOrderPickedUp'])->name('orders.pickup');
        Route::post('/pedidos/{id}/cancelar', [AdminController::class, 'cancelOrder'])->name('orders.cancel');

        // Tasks
        Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/create', [AdminController::class, 'createTask'])->name('tasks.create');
        Route::get('/tasks/create-adoption', [AdminController::class, 'createAdoptionTask'])->name('tasks.createAdoption');
        Route::post('/tasks', [AdminController::class, 'storeTask'])->name('tasks.store');
        Route::put('/tasks/{id}/status', [AdminController::class, 'updateTaskStatus'])->name('tasks.updateStatus');



        // Medical Histories
        Route::get('/medical', [AdminController::class, 'medicalHistories'])->name('medical');

        // Notifications
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
        Route::delete('/notifications/{id}', [AdminController::class, 'deleteNotification'])->name('notifications.delete');
    });

    // PROFILE PASSWORD CHANGE
    Route::get('/cambiar-password', function () {
        return view('profile.password');
    })->name('profile.password');
    Route::put('/cambiar-password', [ProfileController::class, 'changePassword'])->name('profile.password.update');
});
