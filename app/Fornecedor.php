<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $fillable = [
        'nome', 'telefone'
    ];
    protected $table = 'fornecedor';

    public function HistoricoCompraInsumos()
    {
        return $this->hasMany(\App\Models\Insumo\HistoricoCompraInsumo::class, 'id_fornecedor');
    }
    public function HistoricoCompraMedicamentos()
    {
        return $this->hasMany(\App\Models\Animal\HistoricoCompraMedicamento::class, 'id_fornecedor');
    }
    public function HistoricoCompraCombustiveis()
    {
        return $this->hasMany(\App\Models\Maquina\HistoricoCompraCombustivel::class, 'id_fornecedor');
    }
}
