<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    protected $model;
    protected $relationships = [
        'HistoricoCompraInsumos', 'HistoricoCompraMedicamentos'
    ];
    
    public function __construct(\App\Fornecedor $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os fornecedores)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $fornecedores = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return view('pesquisa.pfornecedor', ['fornecedores' => $fornecedores]);
            
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
        return view('cadastro.cfornecedor');        
    }
    
    // Método POST (salva o fornecedor) : OK
    public function store(Request $request)
    {  
        $fazenda = $request->only(
            'nome', 'telefone');
        //Validação
        $validator = $this->Validator($fazenda);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Cadastro
        try 
        {
            $success = $this->model->create($fazenda);

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

    //Método GET (retorna um fornecedor específica)
    public function show($id)
    {
        try
        {
            $fornecedor = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($fornecedor);
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

    //Método PUT (atualiza um fornecedor)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_fornecedor = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_fornecedor->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_fornecedor
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

    //Método DELETE (deleta uma fornecedor específica)
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
            'nome.required'=> 'O campo nome é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
            'telefone.required'=> 'O campo telefone é obrigatório',
            'telefone.max'=> 'O tamanho máximo do campo telefone é 45 caracteres',
        );    
        $rules = array(
            'nome'=>'required|max:100',
            'telefone'=>'required|max:45',
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
