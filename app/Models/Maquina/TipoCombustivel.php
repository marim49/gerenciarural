<?php

namespace App\Models\Maquina;

use Illuminate\Database\Eloquent\Model;

class TipoCombustivel extends Model
{
    protected $fillable = [
        'nome'
    ];
    protected $table = 'tipo_combustivel';   

    public function Combustiveis()
    {
        return $this->hasMany(Combustivel::class, 'id_tipo_combustivel');
    }
}
