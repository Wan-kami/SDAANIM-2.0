<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservas_productos';
    protected $primaryKey = 're_id';
    protected $fillable = ['re_sid', 'prod_id', 'usuario_id', 're_fecha', 're_estado'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'Usu_documento');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id', 'prod_id');
    }
}
