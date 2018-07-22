<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CombustivelController extends Controller
{
    protected $model;
    protected $relationships = [
        'HistoricoAbastecimentos', 'HistoricosCompras', 'Fazenda'
    ];
    
    public function __construct(\App\Models\Maquina\Combustivel $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os combustiveis) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $combustiveis = $this->model->orderBy('id', 'asc')
                ->with('Fazenda')
                ->get();/*->paginate($limit); //limite por páginas */

            return view('pesquisa.pcombustivel', ['combustiveis' => $combustiveis]);
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pcombustivel', ['combustiveis' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }    
    
    //Método GET (chama a view de criação) 
    public function create()
    {
        try
        {            
            $tipos = \App\Models\Maquina\TipoCombustivel::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cadastro.ccombustivel', ['fazendas' => $fazendas, 'tipos' => $tipos]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.ccombustivel', ['fazendas' => [], 'tipos' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }
    
    //Método POST (salva o combustivel) 
    public function store(Request $request)
    {        
        $combustivel = $request->only('id_fazenda', 'id_tipo_combustivel');
        //Validação
        $validator = $this->Validator($combustivel);
        if ($validator->fails()) {
            return redirect('combustivel/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {
            $tipos = \App\Models\Maquina\TipoCombustivel::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $success = $this->model->create($combustivel);
            
            return view('cadastro.ccombustivel', ['success' => $success, 'fazendas' => $fazendas, 'tipos' => $tipos]);
        } 
        catch(\Exception $e) 
        {                      
            return redirect('combustivel/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput(['fazendas' => [], 'tipos' => []]);
        }
    } 

    //Método GET (retorna um combustivel específico)
    public function show($id)
    {
        try
        {
            $combustivel = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($combustivel);
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

    //Método PUT (atualiza um combustivel)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_combustivel = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_combustivel->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_combustivel
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

    //Método DELETE (deleta um combustivel específico)
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
            'id_fazenda.required'=> 'O campo de fazenda é obrigatório',
            'id_tipo_combustivel.required'=>'O campo de tipo do combustível é obrigatório',
            'id_tipo_combustivel.unique_combustivel'=>'Este tipo de combustível já possui um cadastro para essa fazenda',
        );    
        $rules = array(
            'id_fazenda'=>'required',
            'id_tipo_combustivel'=>'required|unique_combustivel',
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
