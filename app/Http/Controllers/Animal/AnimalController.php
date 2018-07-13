<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'GrupoAnimal', 'HistoricoAnimal'
    ];
    
    public function __construct(\App\Models\Animal\Animal $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os animais)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $animais = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($animais);
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
    
    //Método GET (chama a view de criação)
    public function create()
    {
        $grupos = \App\Models\Animal\GrupoAnimal::orderBy('nome', 'asc')->get();
       
        return view('canimal', ['grupos' => $grupos]);
    }

    /* Método POST (salva o animal) : OK
     * (Adicionar view de retorno de erro)
     */
    public function store(Request $request)
    {
        //Validação
        $validator = $this->Validator($request->only('nome', 'id_grupo_animal'));
        if ($validator->fails()) {
            return redirect('animal/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {
            $animal = $request->all();

            $success = $this->model->create($animal);
            $grupos = \App\Models\Animal\GrupoAnimal::orderBy('nome', 'asc')->get();

            return view('canimal', ['success' => $success, 'grupos' => $grupos]);
        } 
        catch(\Exception $e) 
        {
            //Alterar para retornar view de erro
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Nao foi possível inserir o registro. Erro: '.$e->getMessage()
            ]);
        }
    }

    //Método GET (retorna um animal específico)
    public function show($id)
    {
        try
        {
            $animal = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($animal);
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

    //Método PUT (atualiza um animal)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_animal = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_animal->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_animal
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

    //Método DELETE (deleta um animal específico)
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

    //Método que retorna os relacionamentos
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
            'nome.required'=> 'O campo de identificação do animal é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
            'id_grupo_animal.required'=>'O campo de grupo do animal é obrigatório',
        );    
        $rules = array(
            'nome'=>'required|max:45',
            'id_grupo_animal'=>'required',
        );
    
        return Validator::make($requisicao, $rules,$messages);        
    }
}
