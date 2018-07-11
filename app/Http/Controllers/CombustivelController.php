<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CombustivelController extends Controller
{
    protected $model;
    protected $relationships = [
        'TipoCombustivel', 'HistoricoAbastecimentos', 'Compras'
    ];
    
    public function __construct(\App\Combustivel $model)
    {
        $this->model = $model;
    }

    public function GetCombustiveis()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $combustiveis = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($combustiveis);
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
    
    public function PostCombustivel(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $combustivel = $request->all();

            $novo_combustivel = $this->model->create($combustivel);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_combustivel
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

    public function ShowCombustivel($id)
    {
        try
        {
            $combustivel = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($combustivel);
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

    public function UpdateCombustivel(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_combustivel = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_combustivel->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_combustivel
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

    public function DeleteCombustivel($id)
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
