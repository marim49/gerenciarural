<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HistoricoTerraController extends Controller
{
    protected $model;
    protected $relationships = [
        'Insumo.TipoInsumo', 'Terra', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Insumo\HistoricoTerra $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna o histórico da terra) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_terra = $this->model
                ->with($this->relationships())
                ->orderBy('id', 'asc')
                ->get();

            return view('relatorio.rplantio', ['historicos_terra' => $historicos_terra]);
        }
        catch(\Exception $e) 
        {
            return view('relatorio.rplatio', ['historicos_terra' => []])
            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create() 
    {
        try
        {            
            $fazendas = \App\Models\Fazenda\Fazenda::with('Terras', 'Insumos.TipoInsumo', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();

            return view('saida.sinsumo', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('saida.sinsumo', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }    
    
    //Método POST (salva o histórico da terra) : OK  
    public function store(Request $request)
    {
        $plantio = $request->only('id_terra', 'id_insumo', 'id_funcionario', 'quantidade',
                                        'data');
        //Validação
        $validator = $this->Validator($plantio);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        } 
        //Inserção no banco
        try 
        {                     
            $insumo = \App\Models\Insumo\Insumo::find($plantio['id_insumo']);
            
            if($insumo){
                if($plantio['quantidade'] <= 0){
                    throw new \Exception('A quantidade não pode ser negativa ou igual a 0');                    
                }
                if($insumo->quantidade >= $plantio['quantidade']){
                    $insumo->decrement('quantidade', $plantio['quantidade']);
                    $success = $this->model->create($plantio);
                }
                else{                    
                    throw new \Exception('O estoque não possui saldo suficiente para retirada');
                }
            }
            else{
                throw new \Exception('Não foi possível encontrar o insumo no banco de dados');
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

    //Método DELETE (cancela um histórico da terra) : OK
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
            $historico_terra = $this->model->findOrFail($id);                   
            $insumo = \App\Models\Insumo\Insumo::find($historico_terra->id_insumo);
            
            if($insumo){
                $insumo->increment('quantidade', $historico_terra->quantidade);
                $historico_terra->update($resposta);
            }
            else{
                throw new \Exception('Não foi possível encontrar o insumo no banco de dados');
            }              
            
            return redirect()
                            ->back()
                            ->with('success',$historico_terra);
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
                'id_terra.required'=> 'O campo de terra é obrigatório',
                'id_insumo.required'=>'O campo de insumo é obrigatório',
                'id_funcionario.required'=>'O campo de funcionário é obrigatório',
                'quantidade.required'=>'O campo de quantidade é obrigatório',
                'quantidade.numeric'=>'A quantidade só pode ser em números',
                'data.required'=>'O campo de data de data é obrigatório',
                'data.date'=>'O campo de data está em formato inválido',
            );    
            $rules = array(
                'id_terra'=>'required',
                'id_insumo'=>'required',
                'id_funcionario'=>'required',
                'quantidade'=>'required|numeric',
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
