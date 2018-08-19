<?php

namespace App\Http\Controllers\Fazenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FazendaController extends Controller
{
    protected $model;
    protected $relationships = [
        'Insumos', 'Combustiveis', 'Funcionarios',
        'Terras', 'Medicamentos', 'Animais'
    ];
    
    public function __construct(\App\Models\Fazenda\Fazenda $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna as fazendas) : OK
    public function index()
    {
        try
        {    
            //limites por página 
            $limit = 20;       
            $fazendas = $this->model->orderBy('id', 'asc')
                ->get();/*->paginate($limit); //limite por páginas */

           return view('pesquisa.pfazenda', ['fazendas' => $fazendas]);
            
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pfazenda', ['fazendas' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }

    //Método GET (chama a view de criação) : OK
    public function create()
    {
        return view('cadastro.cfazenda');        
    }
    
    // Método POST (salva a fazenda) : OK
    public function store(Request $request)
    {  
        $fazenda = $request->only(
            'nome', 'localidade');
        //Validação
        $validator = $this->Validator($fazenda);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Cadastro
        try 
        {
            $success = $this->model->create($fazenda);

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
    
    //Método PUT (atualiza uma fazenda) : OK
    public function update(Request $request, $id)
    {
        $dados = $request->only('nome', 'localidade');
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
                'nome.max' => 'O tamanho máximo do campo nome é 100 caracteres',
                'localidade.max' => 'O tamanho máximo do campo nome é 45 caracteres',
            );    
            $rules = array(
                'localidade.max' => 'max:45',
                'nome' => 'max:100'
            );
        } 
        else
        {    
            $messages = array(
                'nome.required'=> 'O campo nome é obrigatório',
                'nome.max'=> 'O tamanho máximo do campo nome é 100 caracteres',
                'localidade.max'=> 'O tamanho máximo do campo localidade é 45 caracteres',
            );    
            $rules = array(
                'nome'=>'required|max:100',
                'localidade'=>'max:45',
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
