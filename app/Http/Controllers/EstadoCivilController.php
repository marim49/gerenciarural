<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstadoCivilController extends Controller
{
    protected $model;
    protected $relationships = [
        'Funcionarios'
    ];
    
    public function __construct(\App\EstadoCivil $model)
    {
        $this->model = $model;
    }

    public function GetEstadosCivil()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $estados_civil = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($estados_civil);
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
    
    public function PostEstadoCivil(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $estado_civil = $request->all();

            $novo_estado_civil = $this->model->create($estado_civil);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_estado_civil
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

    public function ShowEstadoCivil($id)
    {
        try
        {
            $estado_civil = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($estado_civil);
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

    public function UpdateEstadoCivil(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_estado_civil = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_estado_civil->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_estado_civil
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

    public function DeleteEstadoCivil($id)
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
