<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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

    //Método GET (retorna o histórico de combustiveis)
    public function index()
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
    
    //Método GET (chama a view de criação) : OK
    public function create() 
    {
        try
        {            
            $fazendas = \App\Models\Fazenda\Fazenda::with('Maquinas', 'Combustiveis.TipoCombustivel', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();

            return view('scombustivel', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('scombustivel', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }    
    
    //Método POST (salva o histórico do combustível) : OK
    public function store(Request $request)
    {
        $abastecimento = $request->only('id_maquina', 'id_combustivel', 'id_funcionario', 'quantidade',
                                        'data');
        //Validação
        $validator = $this->Validator($abastecimento);
        if ($validator->fails()) {
            return redirect('abastecimento/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {          
            $fazendas = \App\Models\Fazenda\Fazenda::with('Maquinas', 'Combustiveis.TipoCombustivel', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();
            
            $combustivel = \App\Models\Maquina\Combustivel::find($abastecimento['id_combustivel']);

            
            if($combustivel){
                if($abastecimento['quantidade'] < 0){
                    throw new \Exception('A quantidade não pode ser negativa');                    
                }
                if($combustivel->quantidade >= $abastecimento['quantidade']){
                    $combustivel->decrement('quantidade', $abastecimento['quantidade']);
                    $success = $this->model->create($abastecimento);
                }
                else{                    
                    throw new \Exception('O estoque não possui saldo suficiente para retirada');
                }
            }
            else{
                throw new \Exception('Não foi possível encontrar o combustível no banco de dados');
            }

            return view('ecombustivel', ['success' => $success, 'fazendas' => $fazendas]);
        } 
        catch(\Exception $e) 
        {                      
            return redirect('abastecimento/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput();
        }
    } 

    //Método GET (retorna um histórico de combustivel específico) 
    public function show($id)
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

    //Método GET (retorna a view de edição)
    public function edit($id){}

    //Método PUT (atualiza um histórico de combustivel)
    public function update(Request $request, $id)
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

    //Método DELETE (deleta um combustivel específico)
    public function destroy($id)
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

    //Método que retorna os relacionamentos : OK
    protected function relationships()
    {
        if(isset($this->relationships)) {
            return $this->relationships;
        }

        return [];
    }     

    //Método de validação : OK
    protected function Validator($requisicao){        
        $messages = array(
            'id_maquina.required'=> 'O campo de máquina é obrigatório',
            'id_combustivel.required'=>'O campo de combustível é obrigatório',
            'id_funcionario.required'=>'O campo de funcionário é obrigatório',
            'quantidade.required'=>'O campo de quantidade é obrigatório',
            'quantidade.numeric'=>'A quantidade só pode ser em números',
            'data.required'=>'O campo de data de abastecimento é obrigatório',
            'data.date'=>'O campo de data está em formato inválido',
        );    
        $rules = array(
            'id_maquina'=>'required',
            'id_combustivel'=>'required',
            'id_funcionario'=>'required',
            'quantidade'=>'required|numeric',
            'data'=>'required|date',
        );
    
        return Validator::make($requisicao, $rules,$messages);        
    }

    //Método de retorno de erro : OK
    protected function Error($message, \Exception $e){
        return [
            'message' => $message.' Erro: '.$e->getMessage()
        ];
    }
}