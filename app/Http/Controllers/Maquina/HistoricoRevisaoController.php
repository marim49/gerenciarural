<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HistoricoRevisaoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Funcionario', 'Maquina'
    ]; 
    
    public function __construct(\App\Models\Maquina\HistoricoRevisao $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os históricos de revisão) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $revisoes = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->get();
                /*->paginate($limit); //limite por páginas */

            return view('relatorio.rrevisao', ['revisoes' => $revisoes]);
        }
        catch(\Exception $e) 
        {
            return view('relatorio.rrevisao', ['revisoes' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $fazendas = \App\Models\Fazenda\Fazenda::with('Maquinas', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();
        
            return view('entrada.erevisao', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.crevisao', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    } 

    // Método POST (salva o histórico de revisão) : OK 
    public function store(Request $request)
    {
        $revisao = $request->only('id_maquina', 'id_funcionario', 'item', 'nota_fiscal', 'valor', 'problema', 'data');
        //Validação
        $validator = $this->Validator($revisao);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Cadastro       
        try 
        {
            $success = $this->model->create($revisao);

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

    //Método DELETE (cancela uma histórico de revisão específico) : OK
    public function destroy(Request $request, $id)
    {
        $resposta = $request->only('motivo', 'cancelado');
        //Validação
        $validator = $this->Validator($resposta, true);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        } 
        try
        {
            $resposta = array_merge($resposta, ['id_user_cancelou' => Auth::user()->id]);
            $historico = $this->model->findOrFail($id);                   

            $historico->update($resposta);            
            
            return redirect()
                            ->back()
                            ->with('success',$historico);
        }
        catch(\Exception $e) 
        {
            return redirect()
                            ->back()
                            ->withErrors($this->Error('Não foi possível atualizar o registro.',$e))
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
    protected function Validator($requisicao, $delete = false){  
        if($delete)
        {
            $messages = array(
                'motivo.required'=> 'O campo de motivo é obrigatório',
                'motivo.max'=>'O tamanho máximo do campo de motivo é 100 caracteres',
                'cancelado.required'=>'A operação não funcionou',
            );    
            $rules = array(
                'motivo'=>'required|max:100',
                'cancelado'=>'required',
            );
        }   
        else
        {       
            $messages = array(
                'id_maquina' => 'O campo de máquina é obrigatório',
                'id_funcionario' => 'O campo de funcionário é obrigatório',
                'item.max'=> 'O tamanho máximo do campo item é 45 caracteres',
                'nota_fiscal.max'=> 'O tamanho máximo do campo nota fiscal é 45 caracteres',
                'valor.numeric'=> 'O campo de valor só pode ter entradas numéricas',
                'problema.required'=> 'O campo de descrição do problema é obrigatório',
                'problema.max'=> 'O tamanho máximo do campo de problema é 191 carcateres',
                'data.required'=> 'O campo data é obrigatório',
                'data.date'=> 'O campo de data só pode ter entradas do tipo de data',
            );    
            $rules = array(
                'id_maquina' => 'required',
                'id_funcionario' => 'required',
                'item'=> 'sometimes|nullable|max:45',
                'nota_fiscal'=> 'sometimes|nullable|max:45',
                'problema'=> 'required|max:191',
                'valor'=> 'sometimes|nullable|numeric',
                'data'=>'required|date',
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
