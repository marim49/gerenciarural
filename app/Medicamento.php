<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $fillable = [
        'id_fazenda', 'id_tipo_medicamento', 'quantidade', 'nome', 'obs'
    ];
    protected $table = 'medicamento';

    public function Fazenda()
    {
        return $this->belongsTo(Fazenda::class, 'id_fazenda');
    }
    public function TipoMedicamento()
    {
        return $this->belongsTo(TipoMedicamento::class, 'id_tipo_medicamento');
    }
    public function HistoricoCompra()
    {
        return $this->hasMany(HistoricoCompraMedicamento::class, 'id_medicamento');
    }
    public function Animais()
    {
        return $this->hasMany(Animal::class, 'id_medicamento');
    }
}
