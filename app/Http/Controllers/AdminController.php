<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Product;
use App\Models\User;
use App\Models\Inscription;
use App\Models\AdoptionRequest;
use App\Models\AdoptionFollowup;
use App\Models\Appointment;
use App\Models\AboutPage;
use App\Models\MedicalHistory;
use App\Models\Task;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Mail\InscriptionStatusMail;
use App\Mail\AdoptionRequestStatusMail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'animals' => Animal::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'adoptions' => AdoptionRequest::where('Soli_estado', 'Pendiente')->count(),
            'volunteers' => User::where('role', 'Voluntario')->count(),
            'veterinarians' => User::where('role', 'Veterinario')->count(),
            'adoptants' => User::where('role', 'Adoptante')->count(),
            'tasks' => Task::where('Tar_estado', 'Pendiente')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ==================== ANIMALS CRUD ====================
    public function animals()
    {
        $animals = Animal::orderBy('Anim_id', 'DESC')->get();
        return view('admin.animals.index', compact('animals'));
    }

    public function createAnimal()
    {
        return view('admin.animals.create');
    }

    public function storeAnimal(Request $request)
    {
        $request->validate([
            'Anim_nombre' => 'required|string|max:200',
            'Anim_raza' => 'required|string|max:200',
            'Anim_edad' => 'required|string|max:100',
            'Anim_estado' => 'required|string|max:50',
            'Anim_sexo' => 'nullable|in:Macho,Hembra',
            'Anim_historia' => 'nullable|string',
            'Anim_foto' => 'required|image|max:5120',
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('Anim_foto')) {
            $file = $request->file('Anim_foto');
            $filename = 'animal_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Asegurar que el directorio existe
            $imgPath = public_path('img');
            if (!is_dir($imgPath)) {
                mkdir($imgPath, 0755, true);
            }
            
            $file->move($imgPath, $filename);
            $data['Anim_foto'] = $filename;
        }

        Animal::create($data);

        return redirect()->route('admin.animals')->with('success', 'Animal agregado correctamente.');
    }

    public function editAnimal($id)
    {
        $animal = Animal::findOrFail($id);
        return view('admin.animals.edit', compact('animal'));
    }

    public function updateAnimal(Request $request, $id)
    {
        $request->validate([
            'Anim_nombre' => 'required|string|max:200',
            'Anim_raza' => 'required|string|max:200',
            'Anim_edad' => 'required|string|max:100',
            'Anim_estado' => 'required|string|max:50',
            'Anim_sexo' => 'nullable|in:Macho,Hembra',
            'Anim_historia' => 'nullable|string',
            'Anim_foto' => 'nullable|image|max:5120',
        ]);

        $animal = Animal::findOrFail($id);
        
        $data = $request->only(['Anim_nombre', 'Anim_raza', 'Anim_edad', 'Anim_estado', 'Anim_sexo', 'Anim_historia']);

        if ($request->hasFile('Anim_foto')) {
            if ($animal->Anim_foto && file_exists(public_path('img/' . $animal->Anim_foto))) {
                unlink(public_path('img/' . $animal->Anim_foto));
            }
            $file = $request->file('Anim_foto');
            $filename = 'animal_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Asegurar que el directorio existe
            $imgPath = public_path('img');
            if (!is_dir($imgPath)) {
                mkdir($imgPath, 0755, true);
            }
            
            $file->move($imgPath, $filename);
            $data['Anim_foto'] = $filename;
        } else {
            // Si no se subió una nueva imagen, no incluir en los datos de actualización
            unset($data['Anim_foto']);
        }

        $animal->update($data);

        return redirect()->route('admin.animals')->with('success', 'Animal actualizado correctamente.');
    }

    public function destroyAnimal($id)
    {
        $animal = Animal::findOrFail($id);
        
        if ($animal->Anim_foto && file_exists(public_path('img/' . $animal->Anim_foto))) {
            unlink(public_path('img/' . $animal->Anim_foto));
        }
        
        $animal->delete();

        return redirect()->route('admin.animals')->with('success', 'Animal eliminado correctamente.');
    }

    // ==================== PRODUCTS CRUD ====================
    public function products()
    {
        $products = Product::orderBy('prod_id', 'DESC')->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.form');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.form', compact('product'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'prod_nombre' => 'required|string|max:100',
            'prod_descripcion' => 'nullable|string',
            'prod_categoria' => 'required|in:Alimentos,Juguetes,Camas,Accesorios,Ropa',
            'prod_precio' => 'required|numeric|min:0',
            'prod_cantidad' => 'required|integer|min:0',
            'prod_imagen' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('prod_imagen')) {
            $file = $request->file('prod_imagen');
            $filename = 'product_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Asegurar que el directorio existe
            $imgPath = public_path('img');
            if (!is_dir($imgPath)) {
                mkdir($imgPath, 0755, true);
            }
            
            $file->move($imgPath, $filename);
            $data['prod_imagen'] = $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Producto guardado correctamente.');
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'prod_nombre' => 'required|string|max:100',
            'prod_descripcion' => 'nullable|string',
            'prod_categoria' => 'required|in:Alimentos,Juguetes,Camas,Accesorios,Ropa',
            'prod_precio' => 'required|numeric|min:0',
            'prod_cantidad' => 'required|integer|min:0',
            'prod_imagen' => 'nullable|image|max:5120',
        ]);

        $product = Product::findOrFail($id);
        
        $data = $request->only(['prod_nombre', 'prod_descripcion', 'prod_categoria', 'prod_precio', 'prod_cantidad']);

        if ($request->hasFile('prod_imagen')) {
            if ($product->prod_imagen && file_exists(public_path('img/' . $product->prod_imagen))) {
                unlink(public_path('img/' . $product->prod_imagen));
            }
            $file = $request->file('prod_imagen');
            $filename = 'product_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Asegurar que el directorio existe
            $imgPath = public_path('img');
            if (!is_dir($imgPath)) {
                mkdir($imgPath, 0755, true);
            }
            
            $file->move($imgPath, $filename);
            $data['prod_imagen'] = $filename;
        } else {
            // Si no se subió una nueva imagen, no incluir en los datos de actualización
            unset($data['prod_imagen']);
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->prod_imagen && file_exists(public_path('img/' . $product->prod_imagen))) {
            unlink(public_path('img/' . $product->prod_imagen));
        }
        
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Producto eliminado correctamente.');
    }

    // ==================== APPOINTMENTS ====================
    public function appointments()
    {
        $animals = Animal::all();
        $veterinarians = User::where('role', 'Veterinario')->get();
        $appointments = Appointment::with(['animal', 'veterinarian'])->orderBy('Cita_fecha', 'DESC')->get();

        return view('admin.appointments.index', compact('animals', 'veterinarians', 'appointments'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'Anim_id' => 'required|exists:animals,Anim_id',
            'Usu_documento' => 'required|exists:users,Usu_documento',
            'Cita_fecha' => 'required|date',
            'Cita_motivo' => 'required|string|max:255',
        ]);

        Appointment::create([
            'Anim_id' => $request->Anim_id,
            'Usu_documento' => $request->Usu_documento,
            'Cita_fecha' => $request->Cita_fecha,
            'Cita_motivo' => $request->Cita_motivo,
            'Cita_estado' => 'Pendiente',
        ]);

        return redirect()->route('admin.appointments')->with('success', 'Cita asignada correctamente.');
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['Cita_estado' => $request->Cita_estado]);

        return redirect()->back()->with('success', 'Estado de cita actualizado.');
    }

    // ==================== ABOUT PAGE ====================
    public function about()
    {
        if (!Schema::hasTable('quienes_somos')) {
            $about = (object) [
                'mision' => 'Proteger y cuidar animales en situación de vulnerabilidad.',
                'vision' => 'Ser un refugio modelo en la protección animal.',
                'valores' => ['Compasión', 'Responsabilidad', 'Dedicación'],
            ];

            return view('admin.about', compact('about'));
        }

        $about = AboutPage::first();
        if (!$about) {
            $about = AboutPage::create([
                'mision' => 'Proteger y cuidar animales en situación de vulnerabilidad.',
                'vision' => 'Ser un refugio modelo en la protección animal.',
                'valores' => json_encode(['Compasión', 'Responsabilidad', 'Dedicación']),
            ]);
        }
        return view('admin.about', compact('about'));
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'mision' => 'required|string',
            'vision' => 'required|string',
            'valores' => 'required|string',
        ]);

        if (!Schema::hasTable('quienes_somos')) {
            return back()->with('error', 'La tabla de Quiénes Somos no existe en la base de datos. Ejecuta las migraciones.');
        }

        $data = $request->all();
        $data['valores'] = json_encode(array_filter(explode("\n", $request->valores)));

        $about = AboutPage::first();
        if ($about) {
            $about->update($data);
        } else {
            AboutPage::create($data);
        }

        return redirect()->route('admin.about')->with('success', 'Información actualizada correctamente.');
    }

    // ==================== USERS MANAGEMENT ====================
    public function adoptants()
    {
        $adoptants = User::where('role', 'Adoptante')->orderBy('email', 'DESC')->get();
        return view('admin.adoptants.index', compact('adoptants'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Rol actualizado correctamente.');
    }

    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'Desactivado']);

        return redirect()->back()->with('success', 'Usuario desactivado.');
    }

    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'Activo']);

        return redirect()->back()->with('success', 'Usuario activado.');
    }

    // ==================== INSCRIPTIONS ====================
    public function veterinarians()
    {
        $veterinarians = User::where('role', 'Veterinario')->orderBy('name', 'ASC')->get();
        $inscriptions = Inscription::where('ins_tipo_rol', 'veterinario')->where('ins_estado', 'Pendiente')->get();
        return view('admin.veterinarians.index', compact('veterinarians', 'inscriptions'));
    }

    public function processVeterinarian(Request $request)
    {
        $inscription = Inscription::findOrFail($request->id);
        $password = null;

        if ($request->accion === 'aceptar') {
            $inscription->update(['ins_estado' => 'Aprobada']);

            $user = User::where('Usu_documento', $inscription->ins_documento)
                        ->orWhere('email', $inscription->ins_email)
                        ->first();
            if ($user) {
                // Actualizar rol y otros datos si el usuario ya existe
                $user->update([
                    'role' => 'Veterinario',
                    'status' => 'Activo'
                ]);
                
                // Forzar recarga de la instancia
                $user->refresh();
            } else {
                // Crear usuario si no existe
                $password = Str::random(10);
                $user = User::create([
                    'Usu_documento' => $inscription->ins_documento,
                    'name' => $inscription->ins_nombre,
                    'email' => $inscription->ins_email,
                    'Usu_telefono' => $inscription->ins_telefono,
                    'Usu_direccion' => $inscription->ins_direccion,
                    'role' => 'Veterinario',
                    'password' => Hash::make($password),
                    'status' => 'Activo',
                ]);
            }
            
            Mail::to($inscription->ins_email)->send(new InscriptionStatusMail('Aprobada', 'Veterinario', $inscription->ins_nombre, $password));

        } elseif ($request->accion === 'rechazar') {
            $inscription->update(['ins_estado' => 'Rechazada']);
            Mail::to($inscription->ins_email)->send(new InscriptionStatusMail('Rechazada', 'Veterinario', $inscription->ins_nombre));
        }

        return redirect()->back()->with('success', 'Veterinario procesado correctamente. El rol ha sido actualizado.');
    }

    public function volunteers()
    {
        $volunteers = User::where('role', 'Voluntario')->orderBy('name', 'ASC')->get();
        $inscriptions = Inscription::where('ins_tipo_rol', 'voluntario')->where('ins_estado', 'Pendiente')->get();
        return view('admin.volunteers.index', compact('volunteers', 'inscriptions'));
    }

    public function processVolunteer(Request $request)
    {
        $inscription = Inscription::findOrFail($request->id);
        $password = null;

        if ($request->accion === 'aceptar') {
            $inscription->update(['ins_estado' => 'Aprobada']);

            $user = User::where('Usu_documento', $inscription->ins_documento)
                        ->orWhere('email', $inscription->ins_email)
                        ->first();
            if ($user) {
                // Actualizar rol y otros datos si el usuario ya existe
                $user->update([
                    'role' => 'Voluntario',
                    'status' => 'Activo'
                ]);
                
                // Forzar recarga de la instancia
                $user->refresh();
            } else {
                // Crear usuario si no existe
                $password = Str::random(10);
                $user = User::create([
                    'Usu_documento' => $inscription->ins_documento,
                    'name' => $inscription->ins_nombre,
                    'email' => $inscription->ins_email,
                    'Usu_telefono' => $inscription->ins_telefono,
                    'Usu_direccion' => $inscription->ins_direccion,
                    'role' => 'Voluntario',
                    'password' => Hash::make($password),
                    'status' => 'Activo',
                ]);
            }

            Mail::to($inscription->ins_email)->send(new InscriptionStatusMail('Aprobada', 'Voluntario', $inscription->ins_nombre, $password));

        } elseif ($request->accion === 'rechazar') {
            $inscription->update(['ins_estado' => 'Rechazada']);
            Mail::to($inscription->ins_email)->send(new InscriptionStatusMail('Rechazada', 'Voluntario', $inscription->ins_nombre));
        }

        return redirect()->back()->with('success', 'Voluntario procesado correctamente. El rol ha sido actualizado.');
    }

    // ==================== ADOPTIONS ====================
    public function adoptions()
    {
        $adoptions = AdoptionRequest::with(['animal', 'user', 'followups', 'volunteer'])
            ->orderBy('Soli_fecha', 'DESC')
            ->get();

        return view('admin.adoptions.index', compact('adoptions'));
    }

    public function showAdoption($id)
    {
        $adoption = AdoptionRequest::with(['animal', 'user', 'followups', 'volunteer'])
            ->findOrFail($id);

        return view('admin.adoptions.show', compact('adoption'));
    }

    public function allAdoptions()
    {
        $adoptions = AdoptionRequest::with(['animal', 'user'])
            ->orderBy('Soli_fecha', 'DESC')
            ->get();

        return view('admin.adoptions.all', compact('adoptions'));
    }

    public function showAssignVolunteer($id)
    {
        $volunteers = User::where('role', 'Voluntario')->get();
        $adoptionId = $id;
        return view('admin.adoptions.assign', compact('volunteers', 'adoptionId'));
    }

    public function assignVolunteer(Request $request)
    {
        $request->validate([
            'Soli_id' => 'required|exists:adoption_requests,Soli_id',
            'vol_id' => 'required|exists:users,Usu_documento',
            'visita_fecha' => 'required|date|after_or_equal:today',
        ]);

        $adoption = AdoptionRequest::findOrFail($request->Soli_id);
        $adoption->update([
            'Soli_estado' => 'En Revisión',
            'Soli_voluntario' => $request->vol_id,
            'visita_fecha' => $request->visita_fecha,
        ]);

        $animal = $adoption->animal;
        $user = $adoption->user;
        $volunteer = User::where('Usu_documento', $request->vol_id)->first();

        Task::create([
            'Usu_documento' => $request->vol_id,
            'Tar_titulo' => 'Seguimiento de Adopción: ' . ($animal->Anim_nombre ?? 'Animal'),
            'Tar_descripcion' => 'Realizar visita al hogar de ' . ($user->name ?? 'Usuario') . ' el ' . $request->visita_fecha . ' como parte del seguimiento de adopción de ' . ($animal->Anim_nombre ?? 'el animal') . '.',
            'Tar_fecha_asignacion' => now(),
            'Tar_fecha_limite' => $request->visita_fecha,
            'Tar_estado' => 'Pendiente',
            'Soli_id' => $request->Soli_id,
        ]);

        Notification::create([
            'Usu_documento' => $request->vol_id,
            'Noti_titulo' => 'Nueva solicitud de seguimiento de adopción',
            'Noti_mensaje' => 'Se te ha asignado la visita de seguimiento para la adopción de ' . ($animal->Anim_nombre ?? 'un animal') . ' el ' . $request->visita_fecha . '.',
            'Noti_tipo' => 'Adopción',
            'Noti_fecha' => now(),
            'Noti_leido' => false,
        ]);

        Notification::create([
            'Usu_documento' => $adoption->Usu_documento,
            'Noti_mensaje' => 'Se ha asignado a ' . ($volunteer->name ?? 'un voluntario') . ' para visitar tu hogar el ' . $request->visita_fecha . '.',
            'Noti_fecha' => now(),
            'Noti_link' => route('adopter.requests'),
        ]);

        $this->sendAdopterStatusEmail(
            $adoption,
            'Tu solicitud de adopción tiene visita programada',
            'Se ha asignado a ' . ($volunteer->name ?? 'un voluntario') . ' para visitar tu hogar el ' . $request->visita_fecha . '. Por favor, mantente pendiente.',
            $request->visita_fecha,
            $volunteer->name ?? null,
            route('adopter.requests')
        );

        return redirect()->route('admin.adoptions')->with('success', 'Voluntario asignado correctamente, tarea creada y adoptante notificado.');
    }

    private function sendAdopterStatusEmail(AdoptionRequest $adoption, string $subjectLine, string $emailMessage, ?string $visitDate = null, ?string $volunteerName = null, ?string $actionUrl = null)
    {
        $user = $adoption->user ?? User::find($adoption->Usu_documento);

        if (!$user || empty($user->email)) {
            Log::warning("No se pudo enviar correo al adoptante para la solicitud {$adoption->Soli_id}: usuario o correo no definido.");
            return;
        }

        try {
            Mail::to($user->email)->send(new AdoptionRequestStatusMail(
                subjectLine: $subjectLine,
                name: $user->name,
                animalName: $adoption->animal->Anim_nombre ?? 'tu adopción',
                status: $adoption->Soli_estado,
                emailMessage: $emailMessage,
                visitDate: $visitDate,
                volunteerName: $volunteerName,
                actionUrl: $actionUrl
            ));
        } catch (\Exception $e) {
            Log::error("Error al enviar email al adoptante ({$user->email}) para la solicitud {$adoption->Soli_id}: {$e->getMessage()}");
        }
    }

    public function approveAdoption($id)
    {
        $adoption = AdoptionRequest::findOrFail($id);
        $adoption->update(['Soli_estado' => 'Aceptada']);

        if ($adoption->animal) {
            $adoption->animal->update(['Anim_estado' => 'Adoptado']);
        }

// Completar tareas de seguimiento relacionadas
        Task::where('Soli_id', $id)
            ->where('Tar_estado', '!=', 'Completado')
            ->update(['Tar_estado' => 'Completado']);

        Notification::create([
            'Usu_documento' => $adoption->Usu_documento,
            'Noti_mensaje' => "Tu solicitud de adopción para {$adoption->animal->Anim_nombre} ha sido aceptada.",
            'Noti_fecha' => now(),
            'Noti_link' => route('adopter.requests'),
        ]);

        $this->sendAdopterStatusEmail(
            $adoption,
            'Solicitud de adopción aceptada',
            '¡Felicidades! Tu solicitud de adopción ha sido aceptada. Ya puedes venir a recoger a tu nueva mascota cuando gustes.',
            $adoption->visita_fecha,
            $adoption->volunteer?->name,
            route('adopter.requests')
        );

        return redirect()->route('admin.adoptions')->with('success', 'Adopción aprobada.');
    }

    public function rejectAdoption($id)
    {
        $adoption = AdoptionRequest::findOrFail($id);
        $adoption->update(['Soli_estado' => 'Rechazada']);

// Completar tareas de seguimiento relacionadas
        Task::where('Soli_id', $id)
            ->where('Tar_estado', '!=', 'Completado')
            ->update(['Tar_estado' => 'Completado']);

        Notification::create([
            'Usu_documento' => $adoption->Usu_documento,
            'Noti_mensaje' => "Tu solicitud de adopción para {$adoption->animal->Anim_nombre} ha sido rechazada.",
            'Noti_fecha' => now(),
            'Noti_link' => route('adopter.requests'),
        ]);

        $this->sendAdopterStatusEmail(
            $adoption,
            'Solicitud de adopción rechazada',
            'Lamentablemente tu solicitud de adopción ha sido rechazada. Te invitamos a intentarlo de nuevo próximamente.',
            $adoption->visita_fecha,
            $adoption->volunteer?->name,
            route('adopter.requests')
        );

        return redirect()->route('admin.adoptions')->with('success', 'Adopción rechazada.');
    }

    // ==================== FOLLOWUPS ====================
    public function createFollowup($soliId)
    {
        $adoption = AdoptionRequest::findOrFail($soliId);
        return view('admin.adoptions.followup', compact('adoption'));
    }

    public function storeFollowup(Request $request, $soliId)
    {
        $request->validate([
            'Segui_tipo' => 'required|in:Entrevista,Visita,Pos_visita',
            'Segui_estado' => 'required|in:Pendiente,En proceso,Aprobada,Rechazada',
            'Segui_descripcion' => 'nullable|string',
            'Segui_fecha' => 'nullable|date',
        ]);

        AdoptionFollowup::create([
            'Soli_id' => $soliId,
            'Segui_tipo' => $request->Segui_tipo,
            'Segui_estado' => $request->Segui_estado,
            'Segui_descripcion' => $request->Segui_descripcion,
            'Segui_fecha' => $request->Segui_fecha,
        ]);

        return redirect()->route('admin.adoptions')->with('success', 'Seguimiento registrado correctamente.');
    }

    // ==================== TASKS ====================
    public function tasks()
    {
        $tasks = Task::with(['user'])
            ->orderBy('Tar_fecha_limite', 'ASC')
            ->get();

        return view('admin.tasks.index', compact('tasks'));
    }

    public function createTask()
    {
        $users = User::whereIn('role', ['Voluntario', 'Veterinario'])->get();
        $adoptions = AdoptionRequest::whereIn('Soli_estado', ['Pendiente', 'En Revisión'])->get();
        $animals = Animal::all();

        return view('admin.tasks.create', compact('users', 'adoptions', 'animals'));
    }

    public function createAdoptionTask()
    {
        $users = User::whereIn('role', ['Voluntario', 'Veterinario'])->get();
        $adoptions = AdoptionRequest::whereIn('Soli_estado', ['Pendiente', 'En Revisión'])->get();
        $animals = Animal::all();

        return view('admin.tasks.create_adoption', compact('users', 'adoptions', 'animals'));
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'Usu_documento' => 'required|exists:users,Usu_documento',
            'Tar_titulo' => 'required|string|max:255',
            'Tar_descripcion' => 'required|string',
            'Tar_base' => 'nullable|string|max:255',
            'Tar_fecha_asignacion' => 'nullable|date',
            'Tar_fecha_limite' => 'required|date',
            'Tar_hora' => 'nullable',
            'Soli_id' => 'nullable|exists:adoption_requests,Soli_id',
            // Nuevos campos
            'Anim_id' => 'nullable|exists:animals,Anim_id',
            'tipo_atencion' => 'nullable|string',
            'prioridad' => 'nullable|string',
            'actividad_voluntario' => 'nullable|string',
            'sector' => 'nullable|string',
        ]);

        $data = $request->all();
        $user = User::where('Usu_documento', $request->Usu_documento)->first();
        $animal = $request->Anim_id ? Animal::find($request->Anim_id) : null;

        // Construir descripción enriquecida
        $extraInfo = "";
        if ($animal) {
            $extraInfo .= "🐾 Animal: {$animal->Anim_nombre} ({$animal->Anim_raza})\n";
        }

        if ($user->role === 'Veterinario') {
            if ($request->tipo_atencion) $extraInfo .= "🩺 Tipo de Atención: {$request->tipo_atencion}\n";
            if ($request->prioridad) $extraInfo .= "⚡ Prioridad: {$request->prioridad}\n";
        } elseif ($user->role === 'Voluntario') {
            if ($request->actividad_voluntario) $extraInfo .= "🎾 Actividad: {$request->actividad_voluntario}\n";
            if ($request->sector) $extraInfo .= "🏢 Sector/Área: {$request->sector}\n";
        }

        if ($extraInfo) {
            $data['Tar_descripcion'] = "--- DETALLES ESPECÍFICOS ---\n" . $extraInfo . "\n--- INSTRUCCIONES ADICIONALES ---\n" . $request->Tar_descripcion;
        }

        Task::create($data);

        return redirect()->route('admin.tasks')->with('success', 'Tarea creada correctamente.');
    }

    public function updateTaskStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update(['Tar_estado' => $request->Tar_estado]);

        return redirect()->back()->with('success', 'Estado de tarea actualizado.');
    }



    // ==================== MEDICAL HISTORIES ====================
    public function medicalHistories()
    {
        $histories = MedicalHistory::with(['animal', 'veterinarian'])
            ->orderBy('Hist_fecha', 'DESC')
            ->get();

        return view('admin.medical.index', compact('histories'));
    }

    // ==================== ORDERS ====================
    public function orders()
    {
        $orders = Order::with('user')
            ->orderBy('ord_fechaCreacion', 'DESC')
            ->get();

        $confirmedOrdersCount = $orders->where('ord_estado', 'recogido')->count();
        $pendingOrdersCount = $orders->where('ord_estado', 'pendiente')->count();
        $cancelledOrdersCount = $orders->where('ord_estado', 'cancelado')->count();

        return view('admin.orders.index', compact('orders', 'confirmedOrdersCount', 'pendingOrdersCount', 'cancelledOrdersCount'));
    }

    public function showOrder($ord_id)
    {
        $order = Order::with(['user', 'items.product'])
            ->findOrFail($ord_id);

        return view('admin.orders.show', compact('order'));
    }

    public function markOrderPickedUp($ord_id)
    {
        $order = Order::findOrFail($ord_id);
        $order->update([
            'ord_estado' => 'recogido',
            'ord_fechaRecogida' => now(),
        ]);

        return redirect()->back()->with('success', 'Pedido marcado como recogido.');
    }

    public function cancelOrder($ord_id)
    {
        $order = Order::findOrFail($ord_id);

        if ($order->ord_estado === 'recogido') {
            return redirect()->back()->with('error', 'No se puede cancelar un pedido ya recogido.');
        }

        foreach ($order->items as $item) {
            $product = $item->product;
            $product->update(['prod_cantidad' => $product->prod_cantidad + $item->oit_cantidad]);
        }

        $order->update(['ord_estado' => 'cancelado']);

        return redirect()->back()->with('success', 'Pedido cancelado y stock restaurado.');
    }

    // ==================== NOTIFICATIONS ====================
    public function notifications()
    {
        $notifications = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function deleteNotification($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notificación eliminada.');
    }
}
