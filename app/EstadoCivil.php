<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $fillable = [
        'nome'
    ];
    protected $table = 'estado_civil';


    public function Funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'id_estado_civil');
    }
}
