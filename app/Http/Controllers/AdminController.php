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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\InscriptionStatusMail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'animals' => Animal::count(),
            'products' => Product::count(),
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
        $about = AboutPage::first();
        return view('admin.about', compact('about'));
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'mision' => 'required|string',
            'vision' => 'required|string',
            'valores' => 'required|string',
        ]);

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
        $veterinarians = Inscription::where('ins_tipo_rol', 'veterinario')->get();
        return view('admin.veterinarians.index', compact('veterinarians'));
    }

    public function processVeterinarian(Request $request)
    {
        $inscription = Inscription::findOrFail($request->id);
        $password = null;

        if ($request->accion === 'aceptar') {
            $inscription->update(['ins_estado' => 'Aprobada']);

            $user = User::where('Usu_documento', $inscription->ins_documento)->first();
            if ($user) {
                $user->update(['role' => 'Veterinario']);
            } else {
                // Crear usuario si no existe
                $password = Str::random(10);
                $user = User::create([
                    'Usu_documento' => $inscription->ins_documento,
                    'name' => $inscription->ins_nombre,
                    'email' => $inscription->ins_email,
                    'Usu_telefono' => $inscription->ins_telefono,
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

        return redirect()->back()->with('success', 'Acción realizada y notificación enviada.');
    }

    public function volunteers()
    {
        $volunteers = Inscription::where('ins_tipo_rol', 'voluntario')->get();
        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function processVolunteer(Request $request)
    {
        $inscription = Inscription::findOrFail($request->id);
        $password = null;

        if ($request->accion === 'aceptar') {
            $inscription->update(['ins_estado' => 'Aprobada']);

            $user = User::where('Usu_documento', $inscription->ins_documento)->first();
            if ($user) {
                $user->update(['role' => 'Voluntario']);
            } else {
                // Crear usuario si no existe
                $password = Str::random(10);
                $user = User::create([
                    'Usu_documento' => $inscription->ins_documento,
                    'name' => $inscription->ins_nombre,
                    'email' => $inscription->ins_email,
                    'Usu_telefono' => $inscription->ins_telefono,
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

        return redirect()->back()->with('success', 'Acción realizada y notificación enviada.');
    }

    // ==================== ADOPTIONS ====================
    public function adoptions()
    {
        $adoptions = AdoptionRequest::with(['animal', 'user', 'followups', 'volunteer'])
            ->orderBy('Soli_fecha', 'DESC')
            ->get();

        return view('admin.adoptions.index', compact('adoptions'));
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
        ]);

        $adoption = AdoptionRequest::findOrFail($request->Soli_id);
        $adoption->update([
            'Soli_estado' => 'En Revisión',
            'Soli_voluntario' => $request->vol_id,
        ]);

        return redirect()->route('admin.adoptions')->with('success', 'Voluntario asignado correctamente.');
    }

    public function approveAdoption($id)
    {
        $adoption = AdoptionRequest::findOrFail($id);
        $adoption->update(['Soli_estado' => 'Aceptada']);

        if ($adoption->animal) {
            $adoption->animal->update(['Anim_estado' => 'Adoptado']);
        }

        return redirect()->route('admin.adoptions')->with('success', 'Adopción aprobada.');
    }

    public function rejectAdoption($id)
    {
        $adoption = AdoptionRequest::findOrFail($id);
        $adoption->update(['Soli_estado' => 'Rechazada']);

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

        return view('admin.tasks.create', compact('users', 'adoptions'));
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
        ]);

        Task::create($request->all());

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

    // ==================== NOTIFICATIONS ====================
    public function notifications()
    {
        $notifications = \App\Models\Notification::orderBy('created_at', 'DESC')->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function deleteNotification($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notificación eliminada.');
    }
}
