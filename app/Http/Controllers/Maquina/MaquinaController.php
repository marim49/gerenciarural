<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MaquinaController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'HistoricoAbastecimentos'
    ];
    
    public function __construct(\App\Models\Maquina\Maquina $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna as máquinas)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $maquinas = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($maquinas);
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
        
            return view('cmaquina', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cmaquina', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }

    // Método POST (salva o animal) : OK 
    public function store(Request $request)
    {
        $maquina = $request->only('id_fazenda', 'nome', 'data_aquisicao');
        //Validação
        $validator = $this->Validator($maquina);
        if ($validator->fails()) {
            return redirect('maquina/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco        
        try 
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $success = $this->model->create($maquina);

            return view('cmaquina', ['success' => $success, 'fazendas' => $fazendas]);
        } 
        catch(\Exception $e) 
        {
            return redirect('maquina/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput(['fazendas' => []]);
        }
    } 

    //Método GET (retorna uma máquina específica)
    public function show($id)
    {
        try
        {
            $maquina = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($maquina);
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

    //Método PUT (atualiza uma máquina) 
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_maquina = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_maquina->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_maquina
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

    //Método DELETE (deleta uma máquina específica)
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
            'id_fazenda' => 'O campo de fazenda é obrigatório',
            'nome.required'=> 'O campo de identificação do animal é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
            'data_aquisicao.required'=>'O campo de data de aquisição é obrigatório',
        );    
        $rules = array(
            'id_fazenda' => 'required',
            'nome'=>'required|max:45',
            'data_aquisicao'=>'required|date',
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
