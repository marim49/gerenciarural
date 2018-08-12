<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class Revisao extends Model
{
    protected $fillable = [
        'id_maquina', 'id_funcionario', 'item', 'nota_fiscal', 'valor', 'problema', 'data'
    ];
    protected $table = 'revisao';

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
