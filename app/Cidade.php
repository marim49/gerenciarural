<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = [
        'id_estado', 'nome'
    ];
    protected $table = 'cidade';

    public function Estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
    public function Fazendas()
    {
        return $this->hasMany(Fazenda::class, 'id_cidade');
    }
    public function Funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'id_cidade');
    }
}
