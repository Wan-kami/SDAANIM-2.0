<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    protected $primaryKey = 'Soli_id';
    protected $fillable = ['Usu_documento', 'Anim_id', 'Soli_fecha', 'Soli_estado', 'Soli_voluntario', 'Soli_motivo', 'Soli_otras_mascotas', 'Soli_tipo_vivienda', 'Soli_tiempo_disponible', 'Soli_comentarios', 'visita_fecha', 'reporte_voluntario', 'apto'];
    protected $casts = [
        'Soli_fecha' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'Anim_id', 'Anim_id');
    }

    public function followups()
    {
        return $this->hasMany(AdoptionFollowup::class, 'Soli_id', 'Soli_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'Soli_voluntario', 'Usu_documento');
    }
}
