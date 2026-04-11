<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $table = 'quienes_somos';
    protected $primaryKey = 'id';
    protected $fillable = ['mision', 'vision', 'valores'];
    public $timestamps = false;
}
