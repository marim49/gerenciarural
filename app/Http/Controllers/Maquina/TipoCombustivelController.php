<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipoCombustivelController extends Controller
{
    protected $model;
    protected $relationships = [
        'Combustiveis'
    ];
    
    public function __construct(\App\Models\Maquina\TipoCombustivel $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os tipo de combustiveis)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $tipos_combustivel = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($tipos_combustivel);
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
        return view('cadastro.ctcombustivel');
    }
    
    //Método POST (salva o tipo de combustível) : OK    
    public function store(Request $request)
    {                
        $tipocombustivel = $request->only('nome');
        //Validação
        $validator = $this->Validator($tipocombustivel);
        if ($validator->fails()) {
            return redirect('tipocombustivel/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco        
        try 
        {
            $success = $this->model->create($tipocombustivel);
            
            return view('cadastro.ctcombustivel', ['success' => $success]);
        } 
        catch(\Exception $e) 
        {                           
            return redirect('tipocombustivel/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e));
        }
    } 

    //Método GET (retorna um tipo de combustivel específico)
    public function show($id)
    {
        try
        {
            $tipo_combustivel = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($tipo_combustivel);
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

    //Método PUT (atualiza um tipo de combustivel)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_tipo_combustivel = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_tipo_combustivel->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_tipo_combustivel
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

    //Método DELETE (deleta um tipo de combustivel específico)
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
            'nome.max'=>'O tamanho máximo do campo nome é 45 caracteres',);    
        $rules = array(
            'nome'=>'required|max:45',
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
