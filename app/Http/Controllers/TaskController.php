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
}
