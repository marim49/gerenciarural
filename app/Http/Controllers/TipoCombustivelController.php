<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TipoCombustivelController extends Controller
{
    protected $model;
    protected $relationships = [
        'Combustiveis'
    ];
    
    public function __construct(\App\TipoCombustivel $model)
    {
        $this->model = $model;
    }

    public function GetTiposCombustivel()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $tipos_combustivel = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($tipos_combustivel);
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
    
    public function PostTipoCombustivel(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $tipo_combustivel = $request->all();

            $novo_tipo_combustivel = $this->model->create($tipo_combustivel);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_tipo_combustivel
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

    public function ShowTipoCombustivel($id)
    {
        try
        {
            $tipo_combustivel = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($tipo_combustivel);
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

    public function UpdateTipoCombustivel(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_tipo_combustivel = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_tipo_combustivel->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_tipo_combustivel
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

    public function DeleteTipoCombustivel($id)
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
