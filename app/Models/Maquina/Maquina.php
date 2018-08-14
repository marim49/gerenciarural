<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $fillable = [
        'nome', 'data_aquisicao', 'id_fazenda'
    ];
    protected $table = 'maquina';

    public function Fazenda()
    {
        return $this->belongsTo(\App\Models\Fazenda\Fazenda::class, 'id_fazenda');
    }
    public function HistoricoAbastecimentos()
    {
        return $this->hasMany(HistoricoAbastecimento::class, 'id_maquina');
    }
    public function Revisoes()
    {
        return $this->hasMany(Revisao::class, 'id_maquina');
    }

    //Atributos    
    //public function getdataaquisicaoAttribute($value) {
    //    return \Carbon\Carbon::parse($value)->format('d/m/Y');
    // }
}
