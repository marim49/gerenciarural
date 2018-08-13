<?php

namespace App\Http\Controllers\Maquina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RevisaoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Funcionario', 'Maquina'
    ]; 
    
    public function __construct(\App\Models\Maquina\Revisao $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna as máquinas) : OK
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
                
            return view('pesquisa.previsao', ['revisoes' => $revisoes]);
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.previsao', ['revisoes' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cadastro.crevisao', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.crevisao', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    } 

    // Método POST (salva o animal) : OK 
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

    //Método GET (retorna uma máquina específica)
    public function show($id)
    {
        try
        {
            $revisao = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($revisao);
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

    //Método PUT (atualiza uma máquina) 
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_revisao = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_revisao->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_revisao
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

    //Método DELETE (deleta uma máquina específica)
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
            'item'=> 'max:45',
            'nota_fiscal'=> 'max:45',
            'problema'=> 'required|max:191',
            'valor'=> 'numeric',
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
