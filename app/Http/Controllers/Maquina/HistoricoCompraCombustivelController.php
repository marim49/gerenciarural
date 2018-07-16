<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HistoricoCompraCombustivelController extends Controller
{
    protected $model;
    protected $relationships = [
        'Combustivel', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Maquina\HistoricoCompraCombustivel $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna as compras de combustiveis)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_compra_combustivel = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($historicos_compra_combustivel);
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

            return view('ecombustivel', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('ecombustivel', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }
    
    //Método POST (salva uma compra de combustivel) : OK
    public function store(Request $request)
    {
        $compra = $request->only('id_combustivel', 'id_funcionario', 'data', 'lote', 'quantidade',
                                 'nota_fiscal', 'valor');
        //Validação
        $validator = $this->Validator($compra);
        if ($validator->fails()) {
            return redirect('compra-combustivel/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {          
            $fazendas = \App\Models\Fazenda\Fazenda::with('Maquinas', 'Combustiveis.TipoCombustivel', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();
            
            $combustivel = \App\Models\Maquina\Combustivel::find($compra['id_combustivel']);

            
            if($combustivel){
                if($compra['quantidade'] < 0){
                    throw new \Exception('A quantidade não pode ser negativa');                    
                }
                else{
                    $combustivel->increment('quantidade', $compra['quantidade']);
                    $success = $this->model->create($compra);
                }
            }
            else{
                throw new \Exception('Não foi possível encontrar o combustível no banco de dados');
            }

            return view('ecombustivel', ['success' => $success, 'fazendas' => $fazendas]);
        } 
        catch(\Exception $e) 
        {                      
            return redirect('compra-combustivel/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput();
        }
    } 

    //Método GET (retorna uma compra de combustivel específico)
    public function show($id)
    {
        try
        {
            $historico_compra_combustivel = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($historico_compra_combustivel);
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

    //Método PUT (atualiza uma compra de combustivel)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_historico_compra_combustivel = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_historico_compra_combustivel->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_historico_compra_combustivel
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
    
    //Método DELETE (deleta uma compra de combustivel específico)
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
            'id_combustivel.required'=>'O campo de combustível é obrigatório',
            'id_funcionario.required'=>'O campo de funcionário é obrigatório',
            'data.required'=>'O campo de data é obrigatório',
            'data.date'=>'O campo de data está em formato inválio',
            'lote.required'=>'O campo de lote é obrigatório',
            'lote.max'=>'O campo de lote só pode ter no máximo 45 caracteres',
            'quantidade.required'=>'O campo de quantidade é obrigatório',
            'quantidade.max'=>'O campo de quantidade só pode ter no máximo 45 caracteres',
            'quantidade.numeric'=>'O campo de quantidade só pode ter entradas numéricas',
            'nota_fiscal.required'=>'O campo de nota fiscal é obrigatório',
            'nota_fiscal.max'=>'O campo de nota fiscal só pode ter no máximo 45 caracteres',
            'valor.required'=>'O campo de valor é obrigatório',
            'valor.max'=>'O campo de valor só pode ter no máximo 45 caracteres',
            'valor.numeric'=>'O campo valor só pode ter entradas numéricas',
        );    
        $rules = array(
            'id_combustivel'=>'required',
            'id_funcionario'=>'required',
            'data'=>'required|date',
            'lote'=>'required|max:45',
            'quantidade'=>'required|max:45|numeric',
            'nota_fiscal'=>'required|max:45',
            'valor'=>'required|max:45|numeric',
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
