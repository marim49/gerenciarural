<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InsumoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Celeiro', 'TipoInsumo', 'HistoricoTerras', 'HistoricoCompraInsumo'
    ];
    
    public function __construct(\App\Models\Insumo\Insumo $model)
    {
        $this->model = $model;
    }

    public function GetInsumos()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $insumos = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($insumos);
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
    
    public function PostInsumo(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $insumo = $request->all();

            $novo_insumo = $this->model->create($insumo);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_insumo
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

    public function ShowInsumo($id)
    {
        try
        {
            $insumo = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($insumo);
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

    public function UpdateInsumo(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_insumo = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_insumo->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_insumo
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

    public function DeleteInsumo($id)
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
