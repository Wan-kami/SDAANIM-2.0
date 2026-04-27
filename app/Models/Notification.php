<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'Noto_id';
    protected $fillable = ['Usu_documento', 'Noti_titulo', 'Noti_mensaje', 'Noti_tipo', 'Noti_fecha', 'Noti_link', 'Noti_leido', 'read_at'];

    protected $casts = [
        'Noti_fecha' => 'date',
        'Noti_leido' => 'boolean',
    ];
}
