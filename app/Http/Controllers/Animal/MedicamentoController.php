<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MedicamentoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'TipoMedicamento', 'HistoricoCompra', 'HistoricoAplicacao'
    ];
    
    public function __construct(\App\Models\Animal\Medicamento $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os medicamentos)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $medicamentos = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($medicamentos);
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
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $tipos = \App\Models\Animal\TipoMedicamento::orderBy('nome', 'asc')->get();
        
            return view('cfarmacia', ['fazendas' => $fazendas, 'tipos' => $tipos]);
        }         
        catch(\Exception $e) 
        {          
            return view('cfarmacia', ['fazendas' => [], 'tipos' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }

    // Método POST (salva o medicamento) : OK    
    public function store(Request $request)
    {        
        $medicamento = $request->only('id_fazenda', 'nome', 'id_tipo_medicamento', 'obs');
        //Validação
        $validator = $this->Validator($medicamento);
        if ($validator->fails()) {
            return redirect('medicamento/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        try 
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $tipos = \App\Models\Animal\TipoMedicamento::orderBy('nome', 'asc')->get();
            $success = $this->model->create($medicamento);

            return view('cfarmacia', ['fazendas' => $fazendas, 'tipos' => $tipos, 'success' => $success]);
        } 
        catch(\Exception $e) 
        {        
            return redirect('farmacia/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput(['fazendas' => [], 'tipos' => [], 'success' => []]);
        }
    } 

    //Método GET (retorna um medicamento específico)
    public function show($id)
    {
        try
        {
            $medicamento = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($medicamento);
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

    //Método PUT (atualiza um medicamento)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_medicamento = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_medicamento->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_medicamento
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

    //Método DELETE (deleta um medicamento específico)
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

    //Método de validação
    protected function Validator($requisicao){        
        $messages = array(
            'id_fazenda.required' => 'Informar a fazenda é obrigatório',
            'id_tipo_medicamento.required' => 'Informar o tipo de medicamento é obrigatório',
            'nome.required'=> 'O campo nome é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
            'obs.max'=>'O campo de observação pode ter no máximo 140 caracteres',
        );    
        $rules = array(
            'id_fazenda' => 'required',
            'id_tipo_medicamento' => 'required',
            'nome'=>'required|max:45',
            'obs'=>'max:140',
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
