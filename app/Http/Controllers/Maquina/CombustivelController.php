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
    
    //Método GET (chama a view de criação) : OK
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
    
    //Método POST (salva o combustivel) : OK
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
