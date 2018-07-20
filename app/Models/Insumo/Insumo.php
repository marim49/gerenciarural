<?php

namespace App\Models\Insumo;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'id_fazenda', 'id_tipo_insumo', 'quantidade', 'nome'
    ];
    protected $table = 'insumo';

    public function Fazenda()
    {
        return $this->belongsTo(Fazenda::class, 'id_fazenda');
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
