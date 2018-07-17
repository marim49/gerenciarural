<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator;

class HistoricoCompraMedicamentoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Medicamento', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Animal\HistoricoCompraMedicamento $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os historicos de medicamentos)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_compra_medicamento = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($historicos_compra_medicamento);
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
            $fazendas = \App\Models\Fazenda\Fazenda::with('Medicamentos.TipoMedicamento', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();

            return view('entrada.efarmacia', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('entrada.efarmacia', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }
    
    //Método POST (salva uma compra de medicamento) : OK    
    public function store(Request $request)
    {
        $compra = $request->only('id_medicamento', 'id_funcionario', 'data', 'lote', 'quantidade',
                                 'nota_fiscal', 'valor');
        //Validação
        $validator = $this->Validator($compra);
        if ($validator->fails()) {
            return redirect('compra-medicamento/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {          
            $fazendas = \App\Models\Fazenda\Fazenda::with('Medicamentos.TipoMedicamento', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();
            
            $medicamento = \App\Models\Animal\Medicamento::find($compra['id_medicamento']);

            
            if($medicamento){
                if($compra['quantidade'] <= 0){
                    throw new \Exception('A quantidade não pode ser negativa ou igual a 0');                    
                }
                else{
                    $medicamento->increment('quantidade', $compra['quantidade']);
                    $success = $this->model->create($compra);
                }
            }
            else{
                throw new \Exception('Não foi possível encontrar o medicamento no banco de dados');
            }

            return view('entrada.efarmacia', ['success' => $success, 'fazendas' => $fazendas]);
        } 
        catch(\Exception $e) 
        {                      
            return redirect('compra-medicamento/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput();
        }
    } 

    //Método GET (retorna uma compra de medicamento específico)
    public function show($id)
    {
        try
        {
            $historico_compra_medicamento = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($historico_compra_medicamento);
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

    //Método PUT (atualiza uma compra de medicamento)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_historico_compra_medicamento = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_historico_compra_medicamento->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_historico_compra_medicamento
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

    //Método DELETE (deleta uma compra de medicamento específico)
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

    //Retorna as relações : OK
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
            'id_medicamento.required'=>'O campo de medicamento é obrigatório',
            'id_funcionario.required'=>'O campo de funcionário é obrigatório',
            'data.required'=>'O campo de data é obrigatório',
            'data.date'=>'O campo de data está em formato inválio',
            'lote.required'=>'O campo de lote é obrigatório',
            'lote.max'=>'O campo de lote só pode ter no máximo 45 caracteres',
            'quantidade.required'=>'O campo de quantidade é obrigatório',
            'quantidade.max'=>'O campo de quantidade só pode ter no máximo 45 caracteres',
            'quantidade.numeric'=>'O campo de quantidade só pode ter entradas numéricas',
            'nota_fiscal.required'=>'O campo de nota fiscal é obrigatório',
            'nota_fiscal.max'=>'O campo de nota fiscal só pode ter no máximo 45 caracteres',
            'valor.required'=>'O campo de valor é obrigatório',
            'valor.max'=>'O campo de valor só pode ter no máximo 45 caracteres',
            'valor.numeric'=>'O campo valor só pode ter entradas numéricas',
        );    
        $rules = array(
            'id_medicamento'=>'required',
            'id_funcionario'=>'required',
            'data'=>'required|date',
            'lote'=>'required|max:45',
            'quantidade'=>'required|numeric',
            'nota_fiscal'=>'required|max:45',
            'valor'=>'required|numeric',
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

