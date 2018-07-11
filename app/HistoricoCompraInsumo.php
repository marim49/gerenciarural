<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoCompraInsumo extends Model
{
    protected $fillable = [
        'id_insumo', 'id_funcionario', 'data', 'lote', 'quantidade', 'nota_fiscal',
        'valor'
    ];
    protected $table = 'historico_compra_insumo';

    public function Insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }
    public function Funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }
}
