<?php

namespace App\Http\Controllers\Fazenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FazendaController extends Controller
{
    protected $model;
    protected $relationships = [
        'Maquinas', 'Combustiveis', 'Funcionarios', 'Celeiro',
        'Terras', 'Medicamentos', 'Animais'
    ];
    
    public function __construct(\App\Models\Fazenda\Fazenda $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna as fazendas)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $fazendas = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return view('pfazenda', ['fazendas' => $fazendas]);
            
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
        return view('cfazenda');        
    }
    
    // Método POST (salva a fazenda) : OK
    public function store(Request $request)
    {  
        $fazenda = $request->only(
            'nome', 'telefone', 'end_cep', 'end_rua', 'end_bairro', 'end_estado', 'end_pais',
            'end_cidade', 'end_numero', 'end_complemento', 'endereco');
        //Validação
        $validator = $this->Validator($fazenda);
        if ($validator->fails()) {
            return redirect('fazenda/create')
                            ->withErrors($validator);
        }
        //Cadastro
        try 
        {
            $success = $this->model->create($fazenda);

            return view('cfazenda', ['success' => $success]);        
        } 
        catch(\Exception $e) 
        {                      
            return redirect('fazenda/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e));
        
        }
    } 

    //Método GET (retorna uma fazenda específica)
    public function show($id)
    {
        try
        {
            $fazenda = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($fazenda);
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

    //Método PUT (atualiza uma fazenda)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_fazenda = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_fazenda->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_fazenda
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

    //Método DELETE (deleta uma fazenda específica)
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
            'nome.max'=> 'O tamanho máximo do campo nome é 100 caracteres',
            'telefone.required'=> 'O campo telefone é obrigatório',
            'telefone.max'=> 'O tamanho máximo do campo telefone é 16 caracteres',
            'end_cep.required'=> 'O campo cep é obrigatório',
            'end_cep.max'=> 'O tamanho máximo do campo cep é 9 caracteres',
            'end_cidade.required'=> 'O campo cidade é obrigatório',
            'end_cidade.max'=> 'O tamanho máximo do campo cidade é 45 caracteres',
            'end_estado.required'=> 'O campo estado é obrigatório',
            'end_estado.max'=> 'O tamanho máximo do campo estado é 45 caracteres',
            'end_pais.required'=> 'O campo país é obrigatório',
            'end_pais.max'=> 'O tamanho máximo do campo país é 45 caracteres',
            'end_bairro.required'=> 'O campo bairro é obrigatório',
            'end_bairro.max'=> 'O tamanho máximo do campo bairro é 45 caracteres',
            'end_rua.required'=> 'O campo rua é obrigatório',
            'end_rua.max'=> 'O tamanho máximo do campo rua é 50 caracteres',
            'end_numero.required'=> 'O campo número é obrigatório',
            'end_numero.max'=> 'O tamanho máximo do campo número é 15 caracteres',
            'end_complemento.max'=> 'O tamanho máximo do campo cep é 20 caracteres',
            'endereco.max'=> 'O tamanho máximo do campo cep é 100 caracteres',
        );    
        $rules = array(
            'nome'=>'required|max:100',
            'telefone'=>'required|max:16',
            'end_cep'=>'required|max:9',
            'end_cidade'=>'required|max:45',
            'end_estado'=>'required|max:45',
            'end_pais'=>'required|max:45',
            'end_bairro'=>'required|max:45',
            'end_rua'=>'required|max:50',
            'end_numero'=>'required|max:15',
            'end_complemento'=>'max:20',
            'endereco'=>'max:100',
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
