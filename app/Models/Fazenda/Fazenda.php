<?php

namespace App\Models\Fazenda;

use Illuminate\Database\Eloquent\Model;

class Fazenda extends Model
{
    protected $fillable = [
        'nome', 'localidade'
    ];
    protected $table = 'fazenda';
  
    public function Maquinas()
    {
        return $this->hasMany(\App\Models\Maquina\Maquina::class, 'id_fazenda');
    }
    public function Combustiveis()
    {
        return $this->hasMany(\App\Models\Maquina\Combustivel::class, 'id_fazenda');
    }
    public function Funcionarios()
    {
        return $this->hasMany(\App\Models\Funcionario\Funcionario::class, 'id_fazenda');
    }
    public function Insumos()
    {
        return $this->hasMany(\App\Models\Insumo\Insumo::class, 'id_fazenda');
    }
    public function Terras()
    {
        return $this->hasMany(\App\Models\Insumo\Terra::class, 'id_fazenda');
    }
    public function Medicamentos()
    {
        return $this->hasMany(\App\Models\Animal\Medicamento::class, 'id_fazenda');
    }
    public function Animais()
    {
        return $this->hasMany(\App\Models\Animal\Animal::class, 'id_fazenda');
    }
}
