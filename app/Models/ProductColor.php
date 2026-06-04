<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'product_colors';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = ['prod_id', 'color_nombre', 'color_hex', 'disponible'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id', 'prod_id');
    }
}
