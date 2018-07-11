<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaquinaController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'HistoricoAbastecimentos'
    ];
    
    public function __construct(\App\Maquina $model)
    {
        $this->model = $model;
    }

    public function GetMaquinas()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $maquinas = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($maquinas);
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
    
    public function PostMaquina(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $maquina = $request->all();

            $nova_maquina = $this->model->create($maquina);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $nova_maquina
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

    public function ShowMaquina($id)
    {
        try
        {
            $maquina = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($maquina);
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

    public function UpdateMaquina(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_maquina = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_maquina->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_maquina
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

    public function DeleteMaquina($id)
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
