<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CeleiroController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'Insumos'
    ];
    
    public function __construct(\App\Models\Insumo\Celeiro $model)
    {
        $this->model = $model;
    }

    public function GetCeleiros()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $celeiros = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($celeiros);
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
    
    public function PostCeleiro(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $celeiro = $request->all();

            $novo_celeiro = $this->model->create($celeiro);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_celeiro
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

    public function ShowCeleiro($id)
    {
        try
        {
            $celeiro = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($celeiro);
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

    public function UpdateCeleiro(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_celeiro = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_celeiro->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_celeiro
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

    public function DeleteCeleiro($id)
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
