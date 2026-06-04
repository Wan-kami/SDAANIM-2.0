<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'oit_id';
    protected $fillable = [
        'ord_id',
        'prod_id',
        'oit_cantidad',
        'oit_precio_unitario',
        'oit_subtotal',
        'talla',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'ord_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id', 'prod_id');
    }
}
