<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'prod_id';
    protected $fillable = ['prod_nombre', 'prod_descripcion', 'prod_categoria', 'prod_precio', 'prod_cantidad', 'prod_imagen', 'fecha_registro'];

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'prod_id', 'prod_id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'prod_id', 'prod_id');
    }

    /**
     * Check if product has color/size variants
     */
    public function hasVariants()
    {
        return $this->prod_categoria === 'Ropa' || $this->prod_categoria === 'Accesorios';
    }
}
