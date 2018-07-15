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
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $grupos = \App\Models\Animal\GrupoAnimal::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('canimal', ['grupos' => $grupos, 'fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('canimal', ['grupos' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }

    // Método POST (salva o animal) : OK     
    public function store(Request $request)
    {
        $animal = $request->only('nome', 'id_grupo_animal', 'id_fazenda');
        //Validação
        $validator = $this->Validator($animal);
        if ($validator->fails()) {
            return redirect('animal/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {
            $success = $this->model->create($animal);
            $grupos = \App\Models\Animal\GrupoAnimal::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();

            return view('canimal', ['success' => $success, 'grupos' => $grupos, 'fazendas' => $fazendas]);
        } 
        catch(\Exception $e) 
        {          
            return redirect('animal/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput(['grupos' => [], 'fazendas' => []]);
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
            'nome.required'=> 'O campo de identificação do animal é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
            'id_grupo_animal.required'=>'O campo de grupo do animal é obrigatório',
            'id_fazenda.required' => 'O campo de fazenda é obrigatório'
        );    
        $rules = array(
            'id_fazenda' => 'required',
            'nome'=>'required|max:45',
            'id_grupo_animal'=>'required',
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
