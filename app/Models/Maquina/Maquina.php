<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $fillable = [
        'nome', 'data_aquisicao', 'id_fazenda'
    ];
    protected $table = 'maquina';

    public function Fazenda()
    {
        return $this->belongsTo(App\Models\Fazenda\Fazenda::class, 'id_fazenda');
    }
    public function HistoricoAbastecimentos()
    {
        return $this->hasMany(HistoricoAbastecimento::class, 'id_maquina');
    }
}
