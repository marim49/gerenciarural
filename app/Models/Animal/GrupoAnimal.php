<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

class GrupoAnimal extends Model
{
    protected $fillable = [
        'nome'
    ];
    protected $table = 'grupo_animal';

    public function Animais()
    {
        return $this->hasMany(Animal::class, 'id_grupo_animal');
    }
}
