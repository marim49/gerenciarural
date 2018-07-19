<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class HistoricoCompraCombustivel extends Model
{
    protected $fillable = [
        'id_combustivel', 'id_funcionario', 'data', 'lote', 'quantidade',
        'nota_fiscal', 'valor', 'id_fornecedor'
    ];
    protected $table = 'historico_compra_combustivel';

    public function Combustivel()
    {
        return $this->belongsTo(Combustivel::class, 'id_combustivel');
    }
    public function Funcionario()
    {
        return $this->belongsTo(\App\Models\Funcionario\Funcionario::class, 'id_funcionario');
    }
    public function Fornecedor()
    {
        return $this->belongsTo(\App\Fornecedor::class, 'id_fornecedor');
    }
}
