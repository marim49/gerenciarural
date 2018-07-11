<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnimalController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'GrupoAnimal', 'HistoricoAnimal'
    ];
    
    public function __construct(\App\Models\Animal\Animal $model)
    {
        $this->model = $model;
    }

    public function GetAnimais()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $animais = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($animais);
        }
        catch(\Exception $e) 
        {
            //Alterar para retornar view de erro
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Não foi possível recuperar os registro. Erro: '.$e->getMessage()
            ]);
        }
    }
    
    public function PostAnimal(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $animal = $request->all();

            $novo_animal = $this->model->create($animal);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_animal
            ]);
        } 
        catch(\Exception $e) 
        {
            //Alterar para retornar view
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Não foi possível inserir o registro. Erro: '.$e->getMessage()
            ]);
        }
    } 

    public function ShowAnimal($id)
    {
        try
        {
            $animal = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($animal);
        }
        catch(\Exception $e)
        {
            //retornar view
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Não foi possível retornar o registro. Erro: '.$e->getMessage()
            ]);
        }
    }   

    public function UpdateAnimal(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_animal = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_animal->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_animal
            ]);
        }
        catch(\Exception $e) 
        {
            //retornar view
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Não foi possível atualizar o registro. Erro: '.$e->getMessage()
            ]);
        }
    }

    public function DeleteAnimal($id)
    {
        try 
        {
            $excluido = $this->model->findOrFail($id);
            $excluido->delete();

            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $excluido
            ]);
        }
        catch(\Exception $e) 
        {
            //retornar view
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Não foi possível remover o registro. Erro: '.$e->getMessage()
            ]);
        }
    }

    protected function relationships()
    {
        if(isset($this->relationships)) {
            return $this->relationships;
        }

        return [];
    }
}
