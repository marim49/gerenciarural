<?php

namespace App\Models\Insumo;

use Illuminate\Database\Eloquent\Model;

class Isumo extends Model
{
    protected $fillable = [
        'id_celeiro', 'id_tipo_insumo', 'quantidade'
    ];
    protected $table = 'insumo';

    public function Celeiro()
    {
        return $this->belongsTo(Celeiro::class, 'id_celeiro');
    }
    public function TipoInsumo()
    {
        return $this->belongsTo(TipoInsumo::class, 'id_tipo_insumo');
    }
    public function HistoricoTerras()
    {
        return $this->hasMany(HistoricoTerra::class, 'id_insumo');
    }
    public function HistoricoCompraInsumo()
    {
        return $this->hasMany(HistoricoCompraInsumo::class, 'id_insumo');
    }
}
