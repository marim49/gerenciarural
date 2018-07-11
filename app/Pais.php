<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable = [
        'nome'
    ];
    protected $table = 'pais';

    public function Estados()
    {
        return $this->hasMany(Estado::class, 'id_pais');
    }
}
