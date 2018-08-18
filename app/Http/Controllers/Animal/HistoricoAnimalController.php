<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HistoricoAnimalController extends Controller
{
    protected $model;
    protected $relationships = [
        'Animal', 'Medicamento', 'Funcionario'
    ]; 
    
    public function __construct(\App\Models\Animal\HistoricoAnimal $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna o histórico de animais) : OK
    public function index() 
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_animais = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->paginate($limit);

            return view('relatorio.raplicacao', ['historicos_animais' => $historicos_animais]);
        }
        catch(\Exception $e) 
        {
            return view('relatorio.raplicacao', ['historicos_animais' => []])
            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create() 
    {
        try
        {            
            $fazendas = \App\Models\Fazenda\Fazenda::with('Animais.GrupoAnimal', 'Medicamentos.TipoMedicamento', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();

            return view('saida.sfarmacia', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('saida.sfarmacia', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }    
    
    //Método POST (salva o histórico do combustível) : OK    
    public function store(Request $request)
    {
        $medicacao = $request->only('id_animal', 'id_medicamento', 'id_funcionario', 'quantidade',
                                        'motivo', 'data');
        //Validação
        $validator = $this->Validator($medicacao);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {         
            
            $medicamento = \App\Models\Animal\Medicamento::find($medicacao['id_medicamento']);
            
            if($medicamento){
                if($medicacao['quantidade'] <= 0){
                    throw new \Exception('A quantidade não pode ser negativa ou igual a 0.');                    
                }
                if($medicamento->quantidade >= $medicacao['quantidade']){
                    $medicamento->decrement('quantidade', $medicacao['quantidade']);
                    $success = $this->model->create($medicacao);
                }
                else{                    
                    throw new \Exception('O estoque não possui saldo suficiente para retirada');
                }
            }
            else{
                throw new \Exception('Não foi possível encontrar o medicamento no banco de dados');
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

    //Método DELETE (cancela um hisórico de animal específico) : OK
    public function destroy(Request $request, $id)
    {
        $resposta = $request->only('motivo_cancelamento', 'cancelado');
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
            $medicamento = \App\Models\Animal\Medicamento::find($historico->id_medicamento);
            
            if($medicamento){
                $medicamento->increment('quantidade', $historico->quantidade);
                $historico->update($resposta);
            }
            else{
                throw new \Exception('Não foi possível encontrar o insumo no banco de dados');
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
    protected function Validator($requisicao, $delete = false)
    {        
        if($delete)
        {
            $messages = array(
                'motivo_cancelamento.required'=> 'O campo de motivo é obrigatório',
                'motivo_cancelamento.max'=>'O tamanho máximo do campo de motivo é 100 caracteres',
                'cancelado.required'=>'A operação não funcionou',
            );    
            $rules = array(
                'motivo_cancelamento'=>'required|max:100',
                'cancelado'=>'required',
            );
        }   
        else
        {   
            $messages = array(
                'id_animal.required'=> 'O campo de animal é obrigatório',
                'id_medicamento.required'=>'O campo de medicamento é obrigatório',
                'id_funcionario.required'=>'O campo de funcionário é obrigatório',
                'quantidade.required'=>'O campo de quantidade é obrigatório',
                'quantidade.numeric'=>'A quantidade só pode ser em números',
                'data.required'=>'O campo de data de abastecimento é obrigatório',
                'data.date'=>'O campo de data está em formato inválido',
                'motivo.max' => 'O tamanho máximo do campo de motivo é 100 carcateres'
            );    
            $rules = array(
                'id_animal'=>'required',
                'id_medicamento'=>'required',
                'id_funcionario'=>'required',
                'quantidade'=>'required|numeric',
                'data'=>'required|date',
                'motivo' => 'max:100'
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
