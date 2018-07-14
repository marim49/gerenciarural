<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class HistoricoAbastecimento extends Model
{
    protected $fillable = [
        'id_maquina', 'id_combustivel', 'id_funcionario', 'quantidade'
    ];
    protected $table = 'historico_abastecimento';

    public function Maquina()
    {
        return $this->belongsTo(Maquina::class, 'id_maquina');
    }
    public function Combustivel()
    {
        return $this->belongsTo(Combustivel::class, 'id_combustivel');
    }
    public function Funcionario()
    {
        return $this->belongsTo(App\Models\Funcionario\Funcionario::class, 'id_funcionario');
    }
}
