<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

//Esse é o model do user (padrãozao criado pelo laravel)
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //Aqui são os atributos que compoe o user, ele usa isso pra validar se vc ta por exemplo
    //na hora do cadastro mandando todos os dados que são preciso
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //Aqui são os atributos que ela não te envia no retorno (não sei se vc reparou mas quando mostrou seus dados
    //não mostrou sua senha)
    protected $hidden = [
        'password', 'remember_token',
    ];
    //ai vc cria os metodos só que td model tem q ter um controller pra manipular (vou criar o controller pra vc)
    //só q tenho q acabar a migrate pra vc criar as tabelas
    // mas e se a gente fazer só um teste cm uma tabela q ja existe ? da certo hehe
    // queria fazer pra ver
    //com qual?
    // pode ser qualquer uma, insumo q é menorzinha
    //vamos usar a animal
}
