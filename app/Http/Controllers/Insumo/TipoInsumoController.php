<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipoInsumoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Insumos'
    ];
    
    public function __construct(\App\Models\Insumo\TipoInsumo $model)
    {
        $this->model = $model;
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
          return view('cadastro.ctinsumo');
    }

    // Método POST (salva o tipo de insumo) : OK
    public function store(Request $request)
    {        
        $tipoinsumo = $request->only('nome');
        //Validação
        $validator = $this->Validator($tipoinsumo);
        if ($validator->fails()) {
            return redirect('tipoinsumo/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        try 
        {
            $success = $this->model->create($tipoinsumo);

            return view('cadastro.ctinsumo', ['success' => $success]);
        } 
        catch(\Exception $e) 
        {            
            return redirect('ctinsumo/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput(['fazendas' => []]);
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
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres'
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
