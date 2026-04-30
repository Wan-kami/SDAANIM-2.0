<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $primaryKey = 'Tar_id';
    protected $fillable = [
        'Usu_documento', 'Tar_titulo', 'Tar_descripcion',
        'Tar_fecha_asignacion', 'Tar_fecha_limite',
        'Tar_estado', 'Tar_comentario', 'Tar_hora', 'Tar_base', 'soli_id'
    ];

    // Cast de fechas a Carbon
    protected $casts = [
        'Tar_fecha_asignacion' => 'datetime',
        'Tar_fecha_limite' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }

    public function adoptionRequest()
    {
        return $this->belongsTo(AdoptionRequest::class, 'soli_id', 'Soli_id');
    }

    public function getStatusColorsAttribute()
    {
        $colors = [
            'Pendiente' => ['bg' => '#fff3cd', 'text' => '#856404', 'border' => '#ffc107', 'progress' => 15],
            'Observación' => ['bg' => '#d1ecf1', 'text' => '#0c5460', 'border' => '#17a2b8', 'progress' => 40],
            'En Proceso' => ['bg' => '#ffeaa7', 'text' => '#d68910', 'border' => '#fd7e14', 'progress' => 75],
            'Completado' => ['bg' => '#d4edda', 'text' => '#155724', 'border' => '#28a745', 'progress' => 100],
        ];

        return $colors[$this->Tar_estado] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#ccc', 'progress' => 0];
    }
}