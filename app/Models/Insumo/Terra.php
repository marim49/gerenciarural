<?php

namespace App\Models\Insumo;

use Illuminate\Database\Eloquent\Model;

class Terra extends Model
{
    protected $fillable = [
        'id_fazenda', 'nome', 'area'
    ];
    protected $table = 'terra';

    public function Fazenda()
    {
        return $this->belongsTo(App\Models\Fazenda\Fazenda::class, 'id_fazenda');
    }
    public function HistoricosTerras()
    {
        return $this->hasMany(HistoricoTerra::class, 'id_terra');
    }
}
