<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class HistoricoRevisao extends Model
{
    protected $fillable = [
        'id_maquina', 'id_funcionario', 'item', 'nota_fiscal', 'valor', 'problema', 'data',
        'cancelado', 'motivo', 'id_user_cancelou'
    ];
    protected $table = 'historico_revisao';

    public function Maquina()
    {
        return $this->belongsTo(\App\Models\Maquina\Maquina::class, 'id_maquina');
    }
    public function Funcionario()
    {
        return $this->belongsTo(\App\Models\Funcionario\Funcionario::class, 'id_funcionario');
    }

    // public function getdataAttribute($value) {
    //     return \Carbon\Carbon::parse($value)->format('d/m/Y');
    // }
}
