<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicamentoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'TipoMedicamento', 'HistoricoCompra', 'Animais'
    ];
    
    public function __construct(\App\Models\Medicamento\Medicamento $model)
    {
        $this->model = $model;
    }

    public function GetMedicamentos()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $medicamentos = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($medicamentos);
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
    
    public function PostMedicamento(Request $request)
    {
        //É preciso fazer validações de dados para evitar campos que por exemplo:
        //Chega o campo nome com 1 caracter e o banco exige no minimo 5.
        try 
        {
            $medicamento = $request->all();

            $novo_medicamento = $this->model->create($medicamento);

            //Alterar para retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $novo_medicamento
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

    public function ShowMedicamento($id)
    {
        try
        {
            $medicamento = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($medicamento);
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

    public function UpdateMedicamento(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_medicamento = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_medicamento->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_medicamento
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

    public function DeleteMedicamento($id)
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
