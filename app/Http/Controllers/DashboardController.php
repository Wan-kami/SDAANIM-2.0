<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Notification;
use App\Models\Animal;
use App\Models\MedicalHistory;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Volunteer Dashboard with stats and activity
     */
    public function volunteerDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'tasks_pending' => Task::where('Usu_documento', $user->Usu_documento)
                ->where('Tar_estado', 'Pendiente')
                ->count(),
            'tasks_completed' => Task::where('Usu_documento', $user->Usu_documento)
                ->where('Tar_estado', 'Completado')
                ->count(),
            'tasks_total' => Task::where('Usu_documento', $user->Usu_documento)->count(),
            'notifications_unread' => Notification::where('Usu_documento', $user->Usu_documento)
                ->whereNull('read_at')
                ->count(),
        ];
        
        // Calculate completion percentage
        $stats['completion_percentage'] = $stats['tasks_total'] > 0 
            ? round(($stats['tasks_completed'] / $stats['tasks_total']) * 100)
            : 0;
        
        // Recent tasks
        $recentTasks = Task::where('Usu_documento', $user->Usu_documento)
            ->orderBy('updated_at', 'DESC')
            ->take(5)
            ->get();
        
        // Recent activity
        $recentNotifications = Notification::where('Usu_documento', $user->Usu_documento)
            ->orderBy('Noti_fecha', 'DESC')
            ->take(8)
            ->get();

        return view('home.volunteer', compact('stats', 'recentTasks', 'recentNotifications'));
    }

    /**
     * Veterinarian Dashboard with stats and activity
     */
    public function vetDashboard()
    {
        $user = Auth::user();
        
        // Get all animals for this vet's medical histories - ordered by most recent or urgent
        $animalIds = MedicalHistory::where('Usu_documento', $user->Usu_documento)
            ->distinct('Anim_id')
            ->pluck('Anim_id')
            ->toArray();
        
        $stats = [
            'animals_under_care' => count($animalIds),
            'medical_histories' => MedicalHistory::where('Usu_documento', $user->Usu_documento)->count(),
            'tasks_pending' => Task::where('Usu_documento', $user->Usu_documento)
                ->where('Tar_estado', 'Pendiente')
                ->count(),
            'tasks_completed' => Task::where('Usu_documento', $user->Usu_documento)
                ->where('Tar_estado', 'Completado')
                ->count(),
            'tasks_total' => Task::where('Usu_documento', $user->Usu_documento)->count(),
            'notifications_unread' => Notification::where('Usu_documento', $user->Usu_documento)
                ->whereNull('read_at')
                ->count(),
        ];
        
        // Calculate completion percentage
        $stats['completion_percentage'] = $stats['tasks_total'] > 0 
            ? round(($stats['tasks_completed'] / $stats['tasks_total']) * 100)
            : 0;
        
        // Recent tasks (urgent priority - by due date)
        $recentTasks = Task::where('Usu_documento', $user->Usu_documento)
            ->orderBy('Tar_fecha_limite', 'ASC')
            ->take(5)
            ->get();
        
        // Recent activity
        $recentNotifications = Notification::where('Usu_documento', $user->Usu_documento)
            ->orderBy('Noti_fecha', 'DESC')
            ->take(8)
            ->get();
        
        // Animals under care - prioritize by treatment urgency or recency
        // Limit to 5 most recent or in-treatment animals
        $animalsUnderCare = !empty($animalIds) 
            ? Animal::whereIn('Anim_id', $animalIds)
                ->orderByRaw("CASE 
                    WHEN Anim_estado = 'En Tratamiento' THEN 1
                    WHEN Anim_estado = 'Recuperándose' THEN 2
                    WHEN Anim_estado = 'Disponible' THEN 3
                    ELSE 4
                END")
                ->orderBy('Anim_id', 'DESC')
                ->take(4)
                ->get()
            : collect();

        return view('home.vet', compact('stats', 'recentTasks', 'recentNotifications', 'animalsUnderCare'));
    }
}
