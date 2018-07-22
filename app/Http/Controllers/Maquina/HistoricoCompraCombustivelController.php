<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HistoricoCompraCombustivelController extends Controller
{
    protected $model;
    protected $relationships = [
        'Combustivel', 'Funcionario', 'Fornecedor'
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
            //return response()->json($historicos_compra_combustivel);
            return view('relatorio.rcompra-combustivel', ['historicos_compra_combustivel' => $historicos_compra_combustivel]);
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
            $fazendas = \App\Models\Fazenda\Fazenda::with('Maquinas', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();
            $fornecedores = \App\Fornecedor::orderBy('nome', 'asc')->get();

            return view('entrada.ecombustivel', ['fazendas' => $fazendas, 'fornecedores' => $fornecedores]);
        }         
        catch(\Exception $e) 
        {          
            return view('entrada.ecombustivel', ['fazendas' => [], 'fornecedores' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }
    
    //Método POST (salva uma compra de combustivel) : OK
    public function store(Request $request)
    {
        $compra = $request->only('id_fazenda', 'id_funcionario', 'data', 'lote', 'quantidade',
                                 'nota_fiscal', 'valor', 'id_fornecedor');
        //Validação
        $validator = $this->Validator($compra);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {          
            $fazendas = \App\Models\Fazenda\Fazenda::with('Maquinas', 'Combustiveis', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();
               
            //Busca o combustivel                                                    
            $combustivel = \App\Models\Maquina\Combustivel::where('id_fazenda',$compra['id_fazenda'])->first();
            
            //Se não achar cria o campo
            if(!$combustivel){
                $combustivel = \App\Models\Maquina\Combustivel::create(['id_fazenda' => $compra['id_fazenda']]);
            }

            if($compra['quantidade'] <= 0){
                throw new \Exception('A quantidade não pode ser negativa ou igual a 0');                    
            }
            else{
                $combustivel->increment('quantidade', $compra['quantidade']);
                $success = $this->model->create($compra);
            }
            
            return redirect()
                            ->back()
                            ->with('success',$success);
        } 
        catch(\Exception $e) 
        {                      
            return redirect()
                            ->back()
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

    //Retorna as relações : OK
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
            'id_fornecedor.required'=>'O campo de fornecedor é obrigatório',
            'id_fazenda.required'=>'O campo de fazenda é obrigatório',
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
            'nota_fiscal.unique'=>'Já existe uma nota fiscal cadastrada com esse número',
            'valor.required'=>'O campo de valor é obrigatório',
            'valor.max'=>'O campo de valor só pode ter no máximo 45 caracteres',
            'valor.numeric'=>'O campo valor só pode ter entradas numéricas',
        );    
        $rules = array(
            'id_fornecedor'=>'required',
            'id_fazenda'=>'required',
            'id_funcionario'=>'required',
            'data'=>'required|date',
            'lote'=>'required|max:45',
            'quantidade'=>'required|numeric',
            'nota_fiscal'=>'required|max:45|unique:historico_compra_combustivel',
            'valor'=>'required|numeric',
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
