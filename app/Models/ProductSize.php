<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_sizes';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = ['prod_id', 'talla', 'disponible', 'cantidad'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id', 'prod_id');
    }
}
