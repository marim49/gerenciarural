<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator;

class HistoricoTerraController extends Controller
{
    protected $model;
    protected $relationships = [
        'Insumo', 'Terra', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Insumo\HistoricoTerra $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna o histórico da terra)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_terra = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($historicos_terra);
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
            $fazendas = \App\Models\Fazenda\Fazenda::with('Terras', 'Celeiro.Insumos.TipoInsumo', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();

            return view('eterra', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('eterra', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }    
    
    //Método POST (salva o histórico da terra) : OK  
    public function store(Request $request)
    {
        $plantio = $request->only('id_terra', 'id_insumo', 'id_funcionario', 'quantidade',
                                        'data');
        //Validação
        $validator = $this->Validator($plantio);
        if ($validator->fails()) {
            return redirect('plantio/create')
                            ->withErrors($validator)
                            ->withInput();
        } 
        //Inserção no banco
        try 
        {                     
            $insumo = \App\Models\Insumo\Insumo::find($plantio['id_insumo']);
            
            if($insumo){
                if($plantio['quantidade'] <= 0){
                    throw new \Exception('A quantidade não pode ser negativa ou igual a 0');                    
                }
                if($insumo->quantidade >= $plantio['quantidade']){
                    $insumo->decrement('quantidade', $plantio['quantidade']);
                    $success = $this->model->create($plantio);
                }
                else{                    
                    throw new \Exception('O estoque não possui saldo suficiente para retirada');
                }
            }
            else{
                throw new \Exception('Não foi possível encontrar o combustível no banco de dados');
            }             
            $fazendas = \App\Models\Fazenda\Fazenda::with('Terras', 'Celeiro.Insumos.TipoInsumo', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();

            return view('eterra', ['success' => $success, 'fazendas' => $fazendas]);
        } 
        catch(\Exception $e) 
        {                      
            return redirect('plantio/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput();
        }
    } 

    //Método GET (retorna um histórico da terra específico)
    public function show($id)
    {
        try
        {
            $historico_terra = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($historico_terra);
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

    //Método PUT (atualiza um histórico da terra)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_historico_terra = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_historico_terra->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_historico_terra
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

    //Método DELETE (deleta um hitórico da terra específico)
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
            'id_terra.required'=> 'O campo de terra é obrigatório',
            'id_insumo.required'=>'O campo de insumo é obrigatório',
            'id_funcionario.required'=>'O campo de funcionário é obrigatório',
            'quantidade.required'=>'O campo de quantidade é obrigatório',
            'quantidade.numeric'=>'A quantidade só pode ser em números',
            'data.required'=>'O campo de data de data é obrigatório',
            'data.date'=>'O campo de data está em formato inválido',
        );    
        $rules = array(
            'id_terra'=>'required',
            'id_insumo'=>'required',
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
