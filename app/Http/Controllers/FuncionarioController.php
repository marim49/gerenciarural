<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FuncionarioController extends Controller
{
    protected $model;
    protected $relationships = [
        'TipoFuncionario', 'EstadoCivil', 'HistoricoAbastecimentos', 'HistoricoCompras',
        'FuncionarioFazendas', 'HistoricoTerras', 'HistoricoCompraInsumo', 'HistoricoCompraMedicamento',
        'HistoricoAnimal'
    ];
    
    public function __construct(\App\Funcionario $model)
    {
        $this->model = $model;
    }

    public function GetFuncionarios()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $funcionarios = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($funcionarios);
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
    
    public function PostFuncionario(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $funcionario = $request->all();

            $novo_funcionario = $this->model->create($funcionario);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_funcionario
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

    public function ShowFuncionario($id)
    {
        try
        {
            $funcionario = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($funcionario);
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

    public function UpdateFuncionario(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_funcionario = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_funcionario->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_funcionario
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

    public function DeleteFuncionario($id)
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
