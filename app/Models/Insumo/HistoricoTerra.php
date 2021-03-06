<?php

namespace App\Models\Insumo;

use Illuminate\Database\Eloquent\Model;

class HistoricoTerra extends Model
{
    protected $fillable = [
        'id_terra', 'id_insumo', 'id_funcionario', 'quantidade', 'data',
        'cancelado', 'motivo', 'id_user_cancelou'
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
        return $this->belongsTo(\App\Models\Funcionario\Funcionario::class, 'id_funcionario');
    }
    
    //Atributos
    public function getdataAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
