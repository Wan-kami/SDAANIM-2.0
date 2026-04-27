<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $primaryKey = 'Hist_id';
    protected $fillable = ['Anim_id', 'Usu_documento', 'Hist_fecha', 'Hist_diagnostico', 'Hist_tratamiento', 'Hist_observaciones'];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'Anim_id', 'Anim_id');
    }

    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }

    public function vet()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }
}
