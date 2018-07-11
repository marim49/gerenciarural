<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fazenda extends Model
{
    protected $fillable = [
        'id_produtor', 'nome', 'telefone', 'end_cep', 'end_id_cidade',
        'end_bairro', 'end_rua', 'end_numero', 'end_complemento',
        'endereco'
    ];
    protected $table = 'fazenda';

    public function Produtor()
    {
        return $this->belongsTo(Produtor::class, 'id_produtor');
    }
    public function Cidade()
    {
        return $this->belongsTo(Cidade::class, 'id_cidade');
    }
    public function Maquinas()
    {
        return $this->hasMany(Maquina::class, 'id_fazenda');
    }
    public function Combustiveis()
    {
        return $this->hasMany(Combustivel::class, 'id_fazenda');
    }
    public function Funcionarios()
    {
        return $this->hasMany(FuncionarioFazenda::class, 'id_fazenda');
    }
    public function Celeiros()
    {
        return $this->hasMany(Celeiro::class, 'id_fazenda');
    }
    public function Terras()
    {
        return $this->hasMany(Terra::class, 'id_fazenda');
    }
    public function Medicamentos()
    {
        return $this->hasMany(Medicamento::class, 'id_fazenda');
    }
    public function GrupoAnimais()
    {
        return $this->hasMany(GrupoAnimal::class, 'id_fazenda');
    }
}
