<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = [
        'id_pais', 'nome', 'sigla'
    ];
    protected $table = 'estado';

    public function Pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }
    public function Cidades()
    {
        return $this->hasMany(Cidade::class, 'id_estado');
    }
}
