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

    //Método GET (retorna as fazendas)
    public function index()
    {
        try
        {            
            $fazendas = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })->get();

            return view('pesquisa.pfazenda', ['fazendas' => $fazendas]);
            
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pfazenda', ['fazendas' => []])
                            ->withErrors($this->Error('Não foi recuperar os registros.',$e));
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

    //Método GET (retorna uma fazenda específica)
    public function show($id)
    {
        try
        {
            $fazenda = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($fazenda);
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

    //Método PUT (atualiza uma fazenda)
    public function update(Request $request, $id)
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
            $fazenda = $this->model->findOrFail($id);            
            $dados = $request->all();

            $success = $fazenda->update($dados);   

            return redirect('fazenda')
                            ->with('success', $success);
        }
        catch(\Exception $e) 
        {
            return redirect()
                            ->back()
                            ->withErrors($this->Error('Não foi possível atualizar o registro.',$e))
                            ->withInput();  
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
            'nome.max'=> 'O tamanho máximo do campo nome é 100 caracteres',
            'localidade.max'=> 'O tamanho máximo do campo localidade é 45 caracteres',
        );    
        $rules = array(
            'nome'=>'required|max:100',
            'localidade'=>'max:45',
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
