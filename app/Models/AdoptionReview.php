<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionReview extends Model
{
    protected $table = 'adoption_reviews';
    protected $primaryKey = 'rev_id';

    protected $fillable = [
        'soli_id',
        'Usu_documento',
        'rev_estrellas',
        'rev_comentario',
    ];

    public function solicitud()
    {
        return $this->belongsTo(AdoptionRequest::class, 'soli_id', 'Soli_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'Usu_documento', 'Usu_documento');
    }
}
