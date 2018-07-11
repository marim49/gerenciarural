<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CidadeController extends Controller
{
    protected $model;
    protected $relationships = [
        'Estado', 'Fazendas', 'Funcionarios'
    ];
    
    public function __construct(\App\Cidade $model)
    {
        $this->model = $model;
    }

    public function GetCidades()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $cidades = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($cidades);
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
    
    public function PostCidade(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $cidade = $request->all();

            $nova_cidade = $this->model->create($cidade);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $nova_cidade
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

    public function ShowCidade($id)
    {
        try
        {
            $cidade = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($cidade);
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

    public function UpdateCidade(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_cidade = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_cidade->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_cidade
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

    public function DeleteCidade($id)
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
