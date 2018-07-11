<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Celeiro extends Model
{
    protected $fillable = [
        'id_fazenda'
    ];
    protected $table = 'celeiro';

    public function Fazenda()
    {
        return $this->belongsTo(Fazenda::class, 'id_fazenda');
    }
    public function Insumos()
    {
        return $this->hasMany(Insumo::class, 'id_celeiro');
    }
}
