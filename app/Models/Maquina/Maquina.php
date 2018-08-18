<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $fillable = [
        'nome', 'data_aquisicao', 'id_fazenda'
    ];
    protected $table = 'maquina';
    protected $append = ['data_aquisicao_convert'];

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
    public function getdataaquisicaoconvertAttribute() {
       return \Carbon\Carbon::parse($this->data_aquisicao)->format('d/m/Y');
    }
}
