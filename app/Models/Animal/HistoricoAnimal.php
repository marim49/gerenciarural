<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

class HistoricoAnimal extends Model
{
    protected $fillable = [
        'id_animal', 'id_medicamento', 'id_funcionario', 'quantidade'
    ];
    protected $table = 'historico_animal';

    public function Animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }
    public function Medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento');
    }
    public function Funcionario()
    {
        return $this->belongsTo(App\Models\Funcionario\Funcionario::class, 'id_funcionario');
    }
}
