<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $primaryKey = 'Don_id';
    protected $fillable = ['Usu_documento', 'Don_fecha', 'Don_monto', 'Don_metodo_pago'];

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }
}
