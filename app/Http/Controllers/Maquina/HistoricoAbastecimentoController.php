<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoAbastecimentoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Maquina', 'Combustivel', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Maquina\HistoricoAbastecimento $model)
    {
        $this->model = $model;
    }

    public function GetHistoricosAbastecimento()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_abastecimento = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($historicos_abastecimento);
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
    
    public function PostHistoricoAbastecimento(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $historico_abastecimento = $request->all();

            $novo_historico_abastecimento = $this->model->create($historico_abastecimento);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_historico_abastecimento
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

    public function ShowHistoricoAbastecimento($id)
    {
        try
        {
            $historico_abastecimento = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($historico_abastecimento);
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

    public function UpdateHistoricoAbastecimento(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_historico_abastecimento = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_historico_abastecimento->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_historico_abastecimento
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

    public function DeleteHistoricoAbastecimento($id)
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
