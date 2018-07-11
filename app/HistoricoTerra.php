<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoTerra extends Model
{
    protected $fillable = [
        'id_terra', 'id_insumo', 'id_funcionario', 'quantidade'
    ];
    protected $table = 'historico_terra';

    public function Terra()
    {
        return $this->belongsTo(Terra::class, 'id_terra');
    }
    public function Insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }
    public function Funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }
}
