<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'id_grupo_animal', 'nome'
    ];
    protected $table = 'animal';

    public function Fazenda()
    {
        return $this->belongsTo(Fazenda::class, 'id_fazenda');
    }
    public function GrupoAnimal()
    {
        return $this->belongsTo(GrupoAnimal::class, 'id_grupo_animal');
    }
    public function HistoricoAnimal()
    {
        return $this->hasMany(HistoricoAnimal::class, 'id_animal');
    }
}
