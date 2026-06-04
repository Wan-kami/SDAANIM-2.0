<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'cart_id';
    protected $fillable = [
        'Usu_documento',
        'prod_id',
        'cart_cantidad',
        'talla',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id', 'prod_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }
}
