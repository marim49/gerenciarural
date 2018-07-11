<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TipoInsumoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Insumos'
    ];
    
    public function __construct(\App\TipoInsumo $model)
    {
        $this->model = $model;
    }

    public function GetTiposInsumo()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $tipos_insumos = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($tipos_insumos);
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
    
    public function PostTipoInsumo(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $tipo_insumo= $request->all();

            $novo_tipo_tipo_insumo = $this->model->create($tipo_insumo);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_tipo_tipo_insumo
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

    public function ShowTipoInsumo($id)
    {
        try
        {
            $tipo_insumo = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($tipo_insumo);
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

    public function UpdateTipoInsumo(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_tipo_insumo = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_tipo_insumo->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_tipo_insumo
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

    public function DeleteTipoInsumo($id)
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
