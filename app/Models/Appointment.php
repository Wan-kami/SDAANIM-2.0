<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'Cita_id';
    protected $fillable = ['Anim_id', 'Usu_documento', 'Cita_fecha', 'Cita_motivo', 'Cita_estado'];
    public $timestamps = false;

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'Anim_id', 'Anim_id');
    }

    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }
}
