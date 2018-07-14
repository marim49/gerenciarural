<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class Combustivel extends Model
{
    protected $fillable = [
        'id_fazenda', 'id_tipo_combustivel', 'quantidade',
    ];
    protected $table = 'combustivel';

    public function TipoCombustivel()
    {
        return $this->belongsTo(TipoCombustivel::class, 'id_tipo_combustivel');
    }
    public function HistoricoAbastecimentos()
    {
        return $this->hasMany(HistoricoAbastecimento::class, 'id_combustivel');
    }
    public function Compras()
    {
        return $this->hasMany(HistoricoCompraCombustivel::class, 'id_combustivel');
    }
}
