<?php

namespace App\Models\Fazenda;

use Illuminate\Database\Eloquent\Model;

class Fazenda extends Model
{
    protected $fillable = [
        'id_produtor', 'nome', 'telefone', 'end_cep',
        'end_bairro', 'end_rua', 'end_numero', 'end_complemento',
        'end_cidade', 'end_estado', 'end_pais', 'endereco'
    ];
    protected $table = 'fazenda';

    public function Produtor()
    {
        return $this->belongsTo(App\User::class, 'id_produtor');
    }
    public function Maquinas()
    {
        return $this->hasMany(App\Models\Maquina\Maquina::class, 'id_fazenda');
    }
    public function Combustiveis()
    {
        return $this->hasMany(App\Models\Maquina\Combustivel::class, 'id_fazenda');
    }
    public function Funcionarios()
    {
        return $this->hasMany(FuncionarioFazenda::class, 'id_fazenda');
    }
    public function Celeiros()
    {
        return $this->hasMany(App\Models\Insumo\Celeiro::class, 'id_fazenda');
    }
    public function Terras()
    {
        return $this->hasMany(App\Models\Insumo\Terra::class, 'id_fazenda');
    }
    public function Medicamentos()
    {
        return $this->hasMany(App\Models\Animal\Medicamento::class, 'id_fazenda');
    }
}
