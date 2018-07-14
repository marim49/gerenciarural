<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CeleiroController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'Insumos'
    ];
    
    public function __construct(\App\Models\Insumo\Celeiro $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os celeiros)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $celeiros = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($celeiros);
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
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cceleiro', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cceleiro', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }
    
    // Método POST (salva o celeiro) : OK
    public function store(Request $request)
    {
        $celeiro = $request->only('nome', 'id_fazenda');
        //Validação
        $validator = $this->Validator($celeiro);
        if ($validator->fails()) {
            return redirect('celeiro/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $success = $this->model->create($celeiro);

            return view('cceleiro', ['success' => $success, 'fazendas' => $fazendas]);

        } 
        catch(\Exception $e) 
        {
            return redirect('celeiro/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput(['fazendas' => []]);
        }
    } 

    //Método GET (retorna um celeiro específico)
    public function show($id)
    {
        try
        {
            $celeiro = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($celeiro);
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

    //Método PUT (atualiza um celeiro)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_celeiro = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_celeiro->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_celeiro
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

    //Método DELETE (deleta um celeiro específica)
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
            'id_fazenda.required'=> 'O campo de identificação da fazenda é obrigatório',
            'id_fazenda.unique' => 'Um celeiro já foi cadastrado para essa fazenda',
            'nome.required'=> 'O campo nome é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
        );    
        $rules = array(
            'nome'=>'required|max:45',
            'id_fazenda'=>'required|unique:celeiro',
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
