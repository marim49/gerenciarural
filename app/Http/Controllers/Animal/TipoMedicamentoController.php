<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipoMedicamentoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Medicamentos'
    ];

    public function __construct(\App\Models\Animal\TipoMedicamento $model)
    {
        $this->model = $model;
    }  
     
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        return view('cadastro.ctmedicamento');
    }

    // Método POST (salva o tipo de medicamento) : OK   
    public function store(Request $request)
    {
        $tipo_medicamento = $request->only('nome');
        //Validação
        $validator = $this->Validator($tipo_medicamento);
        if ($validator->fails()) {
            return redirect('tipomedicamento/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        try 
        {
            $success = $this->model->create($tipo_medicamento);

            return view('cadastro.ctmedicamento', ['success' => $success]);
        } 
        catch(\Exception $e) 
        {
            return redirect('tipomedicamento/create')
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
            'nome.required'=> 'O campo de nome é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
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
