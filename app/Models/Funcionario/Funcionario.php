<?php

namespace App\Models\Funcionario;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'nome', 'id_estado_civil', 'endereco_rua',
        'endereco_numero', 'endereco_bairro', 'id_cidade', 'sexo', 'nascimento',
        'admissao', 'cargo', 'rg', 'cpf', 'pis', 'tel_fixo', 'celular', 'cep'
    ];
    protected $table = 'funcionario';


    public function EstadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'id_estado_civil');
    }
    public function HistoricoAbastecimentos()
    {
        return $this->hasMany(App\Models\Maquina\HistoricoAbastecimento::class, 'id_funcionario');
    }
    public function HistoricoCompras()
    {
        return $this->hasMany(App\Models\Maquina\HistoricoCompraCombustivel::class, 'id_funcionario');
    }
    public function FuncionarioFazendas()
    {
        return $this->hasMany(App\Models\Fazenda\FuncionarioFazenda::class, 'id_funcionario');
    }
    public function HistoricoTerras()
    {
        return $this->hasMany(App\Models\Insumo\HistoricoTerra::class, 'id_funcionario');
    }
    public function HistoricoCompraInsumo()
    {
        return $this->hasMany(App\Models\Insumo\HistoricoCompraInsumo::class, 'id_funcionario');
    }
    public function HistoricoCompraMedicamento()
    {
        return $this->hasMany(App\Models\Animal\HistoricoCompraMedicamento::class, 'id_funcionario');
    }
    public function HistoricoAnimal()
    {
        return $this->hasMany(App\Models\Animal\HistoricoAnimal::class, 'id_funcionario');
    }
}