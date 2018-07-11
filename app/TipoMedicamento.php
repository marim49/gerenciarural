<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMedicamento extends Model
{
    protected $fillable = [
        'nome'
    ];
    protected $table = 'tipo_medicamento';

    public function Medicamentos()
    {
        return $this->hasMany(Medicamento::class, 'id_tipo_medicamento');
    }
}
