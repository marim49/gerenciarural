<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFuncionario extends Model
{
    protected $fillable = [
        'nome'
    ];
    protected $table = 'tipo_funcionario';

    public function Funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'id_tipo_funcionario');
    }
}
