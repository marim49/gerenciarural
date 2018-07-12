<?php

namespace App\Models\Insumo;

use Illuminate\Database\Eloquent\Model;

class TipoInsumo extends Model
{
    protected $fillable = [
        'nome'
    ];
    protected $table = 'tipo_insumo';

    public function Insumos()
    {
        return $this->hasMany(Insumo::class, 'id_tipo_insumo');
    }
}
