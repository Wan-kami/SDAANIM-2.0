<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Mostrar tareas para el voluntario/veterinario actual.
     */
    public function index()
    {
        $tasks = Task::where('Usu_documento', Auth::user()->Usu_documento)
            ->where('Tar_estado', '!=', 'Completado') // Solo pendientes en la vista de gestión
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * VISTA DE PROGRESO (Dashboard visual para el voluntario/vet)
     */
    public function volunteerProgress()
    {
        $allTasks = Task::where('Usu_documento', Auth::user()->Usu_documento)->get();
        
        $completedCount = $allTasks->where('Tar_estado', 'Completado')->count();
        $pendingCount = $allTasks->where('Tar_estado', '!=', 'Completado')->count();
        $totalCount = $allTasks->count();

        return view('tasks.progress', compact('allTasks', 'completedCount', 'pendingCount', 'totalCount'));
    }

    /**
     * MARCAR tarea como completada por voluntario/veterinario.
     */
    public function complete(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($task->Usu_documento != Auth::user()->Usu_documento) {
            abort(403, 'No autorizado.');
        }

        $task->update([
            'Tar_estado' => 'Completado',
            'Tar_comentario' => $request->get('comentario'),
        ]);

        return back()->with('success', 'Tarea completada exitosamente.');
    }

    /**
     * ACTUALIZAR comentario de la tarea.
     */
    public function updateComment(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($task->Usu_documento != Auth::user()->Usu_documento) {
            abort(403, 'No autorizado.');
        }

        $task->update([
            'Tar_comentario' => $request->get('comentario'),
        ]);

        return back()->with('success', 'Comentario de la tarea actualizado exitosamente.');
    }

    /**
     * ACTUALIZAR estado de la tarea (pendiente, observación, en proceso, etc.)
     */
    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'Tar_estado' => 'required|in:Pendiente,Observación,En Proceso,Completado',
        ]);

        $task->update(['Tar_estado' => $request->Tar_estado]);

        return back()->with('success', 'Estado de la tarea actualizado.');
    }

    /**
     * LISTAR todas las tareas para el ADMIN, con voluntarios y veterinarios
     */
    public function adminIndex(Request $request)
    {
        $query = Task::with('user')->latest();

        if ($request->filled('volunteer_id')) {
            $query->where('Usu_documento', $request->volunteer_id);
        }

        if ($request->filled('status')) {
            $query->where('Tar_estado', $request->status);
        }

        $tasks = $query->get();

        // Traer voluntarios Y veterinarios (con case correcto)
        $volunteers = User::whereIn('role', ['Voluntario', 'Veterinario'])->get();

        // Traer disponibilidad futura de cada voluntario/veterinario
        $availabilities = Availability::whereIn('Usu_documento', $volunteers->pluck('Usu_documento'))
            ->where('Ava_date', '>=', now()->toDateString())
            ->orderBy('Ava_date')
            ->orderBy('Ava_start_time')
            ->get()
            ->groupBy('Usu_documento');

        return view('admin.tasks.index', compact('tasks', 'volunteers', 'availabilities'));
    }

    /**
     * PANTALLA EXCLUSIVA DE ACTIVIDADES Filtradas (Voluntarios)
     */
    public function adminActivities(Request $request)
    {
        $query = Task::with('user')->latest();

        // 1. Filtrar por Rol (Voluntario o Veterinario)
        if ($request->filled('role')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('role', $request->role);
            });
        } else {
            $query->whereHas('user', function($q) {
                $q->whereIn('role', ['Voluntario', 'Veterinario']);
            });
        }

        // 2. Filtrar por Usuario (volunteer_id)
        if ($request->filled('volunteer_id')) {
            $query->where('Usu_documento', $request->volunteer_id);
        }

        // 3. Filtrar por Fase/Estado
        if ($request->filled('status')) {
            $query->where('Tar_estado', $request->status);
        }

        $activities = $query->get();
        // Todos los posibles asignados para los dropdowns
        $assignees = User::whereIn('role', ['Voluntario', 'Veterinario'])->get();

        return view('admin.activities.index', compact('activities', 'assignees'));
    }

    /**
     * CREAR una tarea desde el admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'Usu_documento' => 'required|exists:users,Usu_documento',
            'task_type' => 'required|string',
            'Tar_titulo' => 'required|string|max:255',
            'Tar_descripcion' => 'nullable|string',
            'Tar_fecha_limite' => 'required|date',
            'Tar_hora' => 'nullable',
            'Tar_base' => 'nullable|string|max:255',
            // Campos opcionales para voluntarios
            'sector' => 'nullable|string',
            'actividad_voluntario' => 'nullable|string',
            'num_animales' => 'nullable|integer|min:1',
            'duracion_horas' => 'nullable|numeric|min:0.5',
            // Campos opcionales para veterinarios
            'tipo_atencion' => 'nullable|string',
            'animal_especifico' => 'nullable|string',
            'equipamiento' => 'nullable|string',
            'prioridad' => 'nullable|in:Normal,Alta,Urgente',
        ]);

        // Validar disponibilidad
        $usuarioRequerido = User::find($request->Usu_documento);
        if ($usuarioRequerido && in_array($usuarioRequerido->role, ['Voluntario', 'Veterinario'])) {
            $hasAvailability = Availability::where('Usu_documento', $request->Usu_documento)
                ->where('Ava_date', $request->Tar_fecha_limite)
                ->exists();

            if (!$hasAvailability) {
                throw ValidationException::withMessages([
                    'Usu_documento' => 'Rol fuera de disponibilidad para la fecha límite indicada.'
                ]);
            }
        }

        // Construir descripción detallada con campos específicos
        $descripcionDetallada = $request->Tar_descripcion ?: '';

        if ($usuarioRequerido->role === 'Voluntario') {
            $detalles = [];
            if ($request->sector) $detalles[] = "Sector: {$request->sector}";
            if ($request->actividad_voluntario) $detalles[] = "Actividad: {$request->actividad_voluntario}";
            if ($request->num_animales) $detalles[] = "Número de animales: {$request->num_animales}";
            if ($request->duracion_horas) $detalles[] = "Duración estimada: {$request->duracion_horas} horas";

            if (!empty($detalles)) {
                $descripcionDetallada .= "\n\nDetalles específicos:\n" . implode("\n", $detalles);
            }
        } elseif ($usuarioRequerido->role === 'Veterinario') {
            $detalles = [];
            if ($request->tipo_atencion) $detalles[] = "Tipo de atención: {$request->tipo_atencion}";
            if ($request->animal_especifico) $detalles[] = "Animal específico: {$request->animal_especifico}";
            if ($request->equipamiento) $detalles[] = "Equipamiento necesario: {$request->equipamiento}";
            if ($request->prioridad) $detalles[] = "Prioridad: {$request->prioridad}";

            if (!empty($detalles)) {
                $descripcionDetallada .= "\n\nDetalles veterinarios:\n" . implode("\n", $detalles);
            }
        }

        Task::create([
            'Usu_documento' => $request->Usu_documento,
            'Tar_titulo' => $request->Tar_titulo,
            'Tar_descripcion' => $descripcionDetallada,
            'Tar_fecha_asignacion' => now(),
            'Tar_fecha_limite' => $request->Tar_fecha_limite,
            'Tar_hora' => $request->Tar_hora,
            'Tar_base' => $request->Tar_base,
            'Tar_estado' => 'Pendiente',
        ]);

        return back()->with('success', 'Tarea creada correctamente.');
    }

    /**
     * Asignar voluntario/veterinario a una tarea existente
     */
    public function assignVolunteer(Request $request, $taskId)
    {
        $request->validate([
            'voluntario_doc' => 'required|exists:users,Usu_documento',
            'Tar_fecha_limite' => 'required|date',
            'Tar_hora' => 'nullable',
        ]);

        // Validar disponibilidad
        $usuarioRequerido = User::find($request->voluntario_doc);
        if ($usuarioRequerido && in_array($usuarioRequerido->role, ['Voluntario', 'Veterinario'])) {
            $hasAvailability = Availability::where('Usu_documento', $request->voluntario_doc)
                ->where('Ava_date', $request->Tar_fecha_limite)
                ->exists();

            if (!$hasAvailability) {
                throw ValidationException::withMessages([
                    'voluntario_doc' => 'Rol fuera de disponibilidad para la fecha indicada.'
                ]);
            }
        }

        $task = Task::findOrFail($taskId);
        $task->Usu_documento = $request->voluntario_doc;
        $task->Tar_fecha_limite = $request->Tar_fecha_limite;
        $task->Tar_hora = $request->Tar_hora;
        $task->save();

        return redirect()->route('admin.tasks.index')->with('success', 'Voluntario/Veterinario asignado correctamente.');
    }
}