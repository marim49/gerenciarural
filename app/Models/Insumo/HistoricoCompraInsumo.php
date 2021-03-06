<?php

namespace App\Models\Insumo;

use Illuminate\Database\Eloquent\Model;

class HistoricoCompraInsumo extends Model
{
    protected $fillable = [
        'id_insumo', 'id_funcionario', 'data', 'lote', 'quantidade', 'nota_fiscal',
        'valor', 'id_fornecedor', 'cancelado', 'motivo', 'id_user_cancelou'
    ];
    protected $table = 'historico_compra_insumo';

    public function Insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }
    public function Funcionario()
    {
        return $this->belongsTo(\App\Models\Funcionario\Funcionario::class, 'id_funcionario');
    }
    public function Fornecedor()
    {
        return $this->belongsTo(\App\Fornecedor::class, 'id_fornecedor');
    }
    
    //Atributos
    public function getdataAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
