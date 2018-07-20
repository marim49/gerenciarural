<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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

    //Método GET (retorna o histórico de animais)
    public function index() 
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_animais = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($historicos_animais);
        }
        catch(\Exception $e) 
        {
            //Alterar para retornar view de erro
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Não foi possível recuperar os registro. Erro: '.$e->getMessage()
            ]);
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
                                        'data');
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

    //Método GET (retorna um histórico de animal específico) 
    public function show($id)
    {
        try
        {
            $historico_animal = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($historico_animal);
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

    //Método PUT (atualiza um histórico de animal)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_historico_animal = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_historico_animal->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_historico_animal
            ]);
        }
        catch(\Exception $e) 
        {
            //retornar view
            return response()->json([
                'status' => 'ERROR', 
                'item' => 'Não foi possível atualizar o registro. Erro: '.$e->getMessage()
            ]);
        }
    }

    //Método DELETE (deleta um hisórico de animal específico)
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
            'id_animal.required'=> 'O campo de animal é obrigatório',
            'id_medicamento.required'=>'O campo de medicamento é obrigatório',
            'id_funcionario.required'=>'O campo de funcionário é obrigatório',
            'quantidade.required'=>'O campo de quantidade é obrigatório',
            'quantidade.numeric'=>'A quantidade só pode ser em números',
            'data.required'=>'O campo de data de abastecimento é obrigatório',
            'data.date'=>'O campo de data está em formato inválido',
        );    
        $rules = array(
            'id_animal'=>'required',
            'id_medicamento'=>'required',
            'id_funcionario'=>'required',
            'quantidade'=>'required|numeric',
            'data'=>'required|date',
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
