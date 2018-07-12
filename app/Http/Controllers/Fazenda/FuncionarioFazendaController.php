<?php

namespace App\Http\Controllers\Fazenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FuncionarioFazendaController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Fazenda\FuncionarioFazenda $model)
    {
        $this->model = $model;
    }

    public function GetFuncionariosFazenda()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $funcionarios_fazenda = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($funcionarios_fazenda);
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
    
    public function PostFuncionarioFazenda(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $funcionario_fazenda = $request->all();

            $novo_funcionario_fazenda = $this->model->create($funcionario_fazenda);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_funcionario_fazenda
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

    public function ShowFuncionarioFazenda($id)
    {
        try
        {
            $funcionario_fazenda = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($funcionario_fazenda);
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

    public function UpdateFuncionarioFazenda(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_funcionario_fazenda = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_funcionario_fazenda->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_funcionario_fazenda
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

    public function DeleteFuncionarioFazenda($id)
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
