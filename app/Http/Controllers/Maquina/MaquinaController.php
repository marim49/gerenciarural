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

    //Método GET (retorna as máquinas) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $maquinas = $this->model->orderBy('id', 'asc')
                ->with('Fazenda')
                ->get();
                /*->paginate($limit); //limite por páginas */
                
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
                
            return view('pesquisa.pmaquina', ['maquinas' => $maquinas, 'fazendas' => $fazendas]);
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pmaquina', ['maquinas' => [], 'fazendas' => []])
                            ->withErrors($this->Error('Não foi recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cadastro.cmaquina', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.cmaquina', ['fazendas' => []])
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
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Cadastro       
        try 
        {
            $success = $this->model->create($maquina);

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

    //Método PUT (atualiza uma máquina) : OK
    public function update(Request $request, $id)
    {
        $dados = $request->only('nome', 'data_aquisicao', 'id_fazenda');
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
                'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
                'data_aquisicao.date'=>'O campo de data de aquisição está em um formato inválido',
            );    
            $rules = array(
                'id_fazenda' => '',
                'nome'=>'max:45',
                'data_aquisicao'=>'date',
            );
        }
        else
        {
            $messages = array(
                'id_fazenda' => 'O campo de fazenda é obrigatório',
                'nome.required'=> 'O campo nome é obrigatório',
                'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
                'data_aquisicao.required'=>'O campo de data de aquisição é obrigatório',
                'data_aquisicao.date'=>'O campo de data de aquisição está em um formato inválido',
            );    
            $rules = array(
                'id_fazenda' => 'required',
                'nome'=>'required|max:45',
                'data_aquisicao'=>'required|date',
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
