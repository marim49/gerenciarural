<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'id_tipo_funcionario', 'nome', 'id_estado_civil', 'endereco_rua',
        'endereco_numero', 'endereco_bairro', 'id_cidade', 'sexo', 'nascimento',
        'admissao', 'rg', 'cpf', 'pis', 'tel_fixo', 'celular', 'cep'
    ];
    protected $table = 'funcionario';


    public function TipoFuncionario()
    {
        return $this->belongsTo(TipoFuncionario::class, 'id_tipo_funcionario');
    }
    public function EstadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'id_estado_civil');
    }
    public function HistoricoAbastecimentos()
    {
        return $this->hasMany(HistoricoAbastecimento::class, 'id_funcionario');
    }
    public function HistoricoCompras()
    {
        return $this->hasMany(HistoricoCompraCombustivel::class, 'id_funcionario');
    }
    public function FuncionarioFazendas()
    {
        return $this->hasMany(FuncionarioFazenda::class, 'id_funcionario');
    }
    public function HistoricoTerras()
    {
        return $this->hasMany(HistoricoTerra::class, 'id_funcionario');
    }
    public function HistoricoCompraInsumo()
    {
        return $this->hasMany(HistoricoCompraInsumo::class, 'id_funcionario');
    }
    public function HistoricoCompraMedicamento()
    {
        return $this->hasMany(HistoricoCompraMedicamento::class, 'id_funcionario');
    }
    public function HistoricoAnimal()
    {
        return $this->hasMany(HistoricoAnimal::class, 'id_funcionario');
    }
}
