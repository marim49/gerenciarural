<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class Combustivel extends Model
{
    protected $fillable = [
        'id_fazenda', 'quantidade',
    ];
    protected $table = 'combustivel';

    public function Fazenda()
    {
        return $this->belongsTo(\App\Models\Fazenda\Fazenda::class, 'id_fazenda');
    }
    public function HistoricoAbastecimentos()
    {
        return $this->hasMany(HistoricoAbastecimento::class, 'id_combustivel');
    }
    public function HistoricosCompras()
    {
        return $this->hasMany(HistoricoCompraCombustivel::class, 'id_combustivel');
    }
}
