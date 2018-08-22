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
