<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GrupoAnimalController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'Animais'
    ];
    
    public function __construct(\App\Models\Animal\GrupoAnimal $model)
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
            
            $grupo_animais = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($grupo_animais);
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
        return view('cadastro.cganimal');        
    }
    
    // Método POST (salva um grupo de animal) : OK    
    public function store(Request $request)
    {
        $grupoanimal = $request->only('nome');
        //Validação
        $validator = $this->Validator($grupoanimal);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Cadastro
        try 
        {
            $success = $this->model->create($grupoanimal);

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

    //Método GET (retorna uma grupo de animal específica)
    public function show($id)
    {
        try
        {
            $grupo_animal = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($grupo_animal);
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

    //Método PUT (atualiza um grupo de animal)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_grupo_animal = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_grupo_animal->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_grupo_animal
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
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
            'localidade.required'=> 'O campo localidade é obrigatório',
        );    
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
