<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    //eu coloquei isso pq por padrão o laravel sempre procura a tabela q  equivale ao plural do nome da model
    //só que sua tabela não se chama 'animals' então tive q setar o nome da tabela
    protected $table = 'animal';

    protected $fillable = ['nome_animal', 'numero_registro', 'peso', 'tratamento_feito', 'historico', 'pai_animal', 
    'data_nasc_animal', 'medicamentos_usados', 'mae_animal', 'data_chegada', 'id_fazenda'];

    //a sua tabela não tem isso, e o laravel sempre insere ele na hr da criação temos q desativa-lo
    public $timestamps = false; //vou confirmar pq n lembro bem

    //Vou fazer bem simples
    public function Fazenda()
    {
        return $this->hasOne(Fazenda::class, 'id_fazenda');
    }    
}
