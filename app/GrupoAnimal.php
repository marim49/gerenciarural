<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoAnimal extends Model
{
    protected $fillable = [
        'nome', 'id_fazenda'
    ];
    protected $table = 'grupo_animal';

    public function Fazenda()
    {
        return $this->belongsTo(Fazenda::class, 'id_fazenda');
    }
    public function Animais()
    {
        return $this->hasMany(Animal::class, 'id_grupo_animal');
    }
}
