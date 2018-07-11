<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

class HistoricoCompraMedicamento extends Model
{
    protected $fillable = [
        'id_medicamento', 'id_funcionario', 'data', 'lote', 'quantidade',
        'nota_fiscal', 'valor'
    ];
    protected $table = 'historico_compra_medicamento';

    public function Medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento');
    }
    public function Funcionario()
    {
        return $this->belongsTo(App\Models\Funcionario\Funcionario::class, 'id_funcionario');
    }
}
