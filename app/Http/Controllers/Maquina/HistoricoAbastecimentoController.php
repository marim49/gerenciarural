<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HistoricoAbastecimentoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Maquina', 'Combustivel', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Maquina\HistoricoAbastecimento $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna o histórico de combustiveis) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_abastecimento = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->paginate($limit);

            return view('relatorio.rabastecimento', ['historicos_abastecimento' => $historicos_abastecimento]);
        }
        catch(\Exception $e) 
        {
            return view('relatorio.rabastecimento', ['historicos_abastecimento' => []])
            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }       
    
    //Método GET (chama a view de criação) : OK
    public function create() 
    {
        try
        {            
            $fazendas = \App\Models\Fazenda\Fazenda::with('Maquinas', 'Combustiveis', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();

            return view('saida.scombustivel', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('saida.scombustivel', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }    
    
    //Método POST (salva o histórico do combustível) : OK
    public function store(Request $request)
    {
        $abastecimento = $request->only('id_maquina', 'id_combustivel', 'id_funcionario', 'quantidade',
                                        'horimetro', 'data');
        //Validação
        $validator = $this->Validator($abastecimento);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {                     
            $combustivel = \App\Models\Maquina\Combustivel::find($abastecimento['id_combustivel']);
            
            if($combustivel){
                if($abastecimento['quantidade'] <= 0){
                    throw new \Exception('A quantidade não pode ser negativa ou igual a 0');                    
                }
                if($combustivel->quantidade >= $abastecimento['quantidade']){
                    $combustivel->decrement('quantidade', $abastecimento['quantidade']);
                    $success = $this->model->create($abastecimento);
                }
                else{                    
                    throw new \Exception('O estoque não possui saldo suficiente para retirada');
                }
            }
            else{
                throw new \Exception('Não foi possível encontrar o combustível no banco de dados');
            }             
            
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

    //Método DELETE (cancela um hitórico de abastecimento específico) : OK
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
            $combustivel = \App\Models\Maquina\Combustivel::find($historico->id_combustivel);
            
            if($combustivel){
                $combustivel->increment('quantidade', $historico->quantidade);
                $historico->update($resposta);
            }
            else{
                throw new \Exception('Não foi possível encontrar o combustível no banco de dados');
            }              
            
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
                'id_maquina.required'=> 'O campo de máquina é obrigatório',
                'id_combustivel.required'=>'O campo de combustível é obrigatório',
                'id_funcionario.required'=>'O campo de funcionário é obrigatório',
                'quantidade.required'=>'O campo de quantidade é obrigatório',
                'quantidade.numeric'=>'A quantidade só pode ser em números',
                'horimetro.required'=>'O campo de horímetro é obrigatório',
                'horimetro.numeric'=>'O horímetro só pode ser em números',
                'data.required'=>'O campo de data de abastecimento é obrigatório',
                'data.date'=>'O campo de data está em formato inválido',
            );    
            $rules = array(
                'id_maquina'=>'required',
                'id_combustivel'=>'required',
                'id_funcionario'=>'required',
                'quantidade'=>'required|numeric',
                'horimetro'=>'required|numeric',
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