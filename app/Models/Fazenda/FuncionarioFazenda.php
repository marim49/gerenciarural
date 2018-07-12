<?php

namespace App\Models\Fazenda;

use Illuminate\Database\Eloquent\Model;

class FuncionarioFazenda extends Model
{
    protected $fillable = [
        'id_funcionario', 'id_fazenda'
    ];
    protected $table = 'funcionario_fazenda';

    public function Fazenda()
    {
        return $this->belongsTo(App\Models\Funcionario\Funcionario::class, 'id_fazenda');
    }
    public function Funcionario()
    {
        return $this->belongsTo(Fazenda::class, 'id_funcionario');
    }
}
