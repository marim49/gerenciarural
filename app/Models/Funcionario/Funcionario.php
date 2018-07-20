<?php

namespace App\Models\Funcionario;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'nome', 'id_fazenda', 'id_estado_civil', 'endereco_rua',
        'endereco_numero', 'endereco_bairro', 'endereco_cidade',
        'endereco_estado', 'endereco_pais', 'sexo', 'nascimento',
        'admissao', 'cargo', 'rg', 'cpf', 'pis', 'tel_fixo', 'celular', 'cep'
    ];
    protected $table = 'funcionario';


    public function EstadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'id_estado_civil');
    }
    public function Fazenda()
    {
        return $this->belongsTo(\App\Models\Fazenda\Fazenda::class, 'id_fazenda');
    }
    public function HistoricoAbastecimentos()
    {
        return $this->hasMany(\App\Models\Maquina\HistoricoAbastecimento::class, 'id_funcionario');
    }
    public function HistoricoCompras()
    {
        return $this->hasMany(\App\Models\Maquina\HistoricoCompraCombustivel::class, 'id_funcionario');
    }
    public function HistoricoTerras()
    {
        return $this->hasMany(\App\Models\Insumo\HistoricoTerra::class, 'id_funcionario');
    }
    public function HistoricoCompraInsumo()
    {
        return $this->hasMany(\App\Models\Insumo\HistoricoCompraInsumo::class, 'id_funcionario');
    }
    public function HistoricoCompraMedicamento()
    {
        return $this->hasMany(\App\Models\Animal\HistoricoCompraMedicamento::class, 'id_funcionario');
    }
    public function HistoricoAnimal()
    {
        return $this->hasMany(\App\Models\Animal\HistoricoAnimal::class, 'id_funcionario');
    }

    //Atributos
    public function getnascimentoAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
    public function getadmissaoAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
