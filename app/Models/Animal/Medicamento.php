<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $fillable = [
        'id_fazenda', 'id_tipo_medicamento', 'quantidade', 'nome', 'obs'
    ];
    protected $table = 'medicamento';

    public function Fazenda()
    {
        return $this->belongsTo(\App\Models\Fazenda\Fazenda::class, 'id_fazenda');
    }
    public function TipoMedicamento()
    {
        return $this->belongsTo(TipoMedicamento::class, 'id_tipo_medicamento');
    }
    public function HistoricoCompra()
    {
        return $this->hasMany(HistoricoCompraMedicamento::class, 'id_medicamento');
    }
    public function HistoricoAplicacao()
    {
        return $this->hasMany(HistoricoAnimal::class, 'id_medicamento');
    }
}
