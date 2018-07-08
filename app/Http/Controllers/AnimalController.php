<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimalController extends Controller
{
    protected $model;
    protected $relationships = [
        'id_fazenda'
    ];
    
    public function __construct(\App\Animal $model)
    {
        $this->model = $model;
    }

    //Cria um animal
    public function Create(Request $request){ 
        

        //aqui ele pega os valores que chegaram por parametro
        $item = $request->all();

        //cria um animal com os parametros   chegaram (tem q tratar antes pra ver se estão certo)
        $result = $this->model->create($item);

        return $result;
    }

    //pega os animais
    public function GetAnimal(){
        //limite de requisição que chega do banco        
        $limit = 20;

        //Aqui busca os animais e os retornam ordenados
        $result = $this->model->orderBy('id_animal', 'asc')
            // ->with($this->relationships()) //isso é onde ele faz o select no relacionamento 
            // ->where(function($query){
            //     return $query;
            // })
            ->paginate($limit);
           // return $result;
           return view('pfuncionario')->with('result',$result);
    }

    
    protected function relationships()
    {
        if(isset($this->relationships)) {
            return $this->relationships;
        }

        return [];
    }
}
