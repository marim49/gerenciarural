<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    protected $model;
    protected $relationships = [
        'HistoricoCompraInsumos', 'HistoricoCompraMedicamentos', 'HistoricoCompraCombustiveis'
    ];
    
    public function __construct(\App\Fornecedor $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os fornecedores) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $fornecedores = $this->model->orderBy('id', 'asc')
                    ->get();/*->paginate($limit); //limite por páginas */

            return view('pesquisa.pfornecedor', ['fornecedores' => $fornecedores]);
            
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pfornecedor', ['fornecedores' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
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

    //Método PUT (atualiza um fornecedor) : OK
    public function update(Request $request, $id)
    {
        $dados = $request->only('nome', 'telefone');
        foreach ($dados as $key => $value) {
            if ($value == null) {
                unset($dados[$key]);
            }
        }
        //Validação
        $validator = $this->Validator($dados, true);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //tratar entrada
        try
        {
            $update = $this->model->findOrFail($id);      

            $update->update($dados);
            
            return redirect()
                            ->back()
                            ->with('success',$update); 
        }
        catch(\Exception $e) 
        {
            return redirect()
                            ->back()
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput();  
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
    protected function Validator($requisicao, $update = false){  
        if($update)       
        {
            $messages = array(
                'nome.max' => 'O tamanho máximo do campo nome é 100 caracteres',
                'telefone.max' => 'O tamanho máximo do campo de observações é 45 caracteres',
            );    
            $rules = array(
                'nome' => 'max:100',
                'telefone' => 'max:45'
            );
        }
        else
        {      
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
        }
    
        return Validator::make($requisicao, $rules,$messages);        
    }
    
    //Método de retorno de erro : OK
    protected function Error($message, \Exception $e){
        return [
            'message' => $message.' Erro: '.$e->getMessage()
        ];
    }
}
