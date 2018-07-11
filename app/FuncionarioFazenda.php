<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuncionarioFazenda extends Model
{
    protected $fillable = [
        'id_funcionario', 'id_fazenda'
    ];
    protected $table = 'funcionario_fazenda';

    public function Fazenda()
    {
        return $this->belongsTo(Funcionario::class, 'id_fazenda');
    }
    public function Funcionario()
    {
        return $this->belongsTo(Fazenda::class, 'id_funcionario');
    }
}
