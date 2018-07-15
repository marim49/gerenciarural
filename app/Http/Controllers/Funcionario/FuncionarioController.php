<?php

namespace App\Http\Controllers\Funcionario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FuncionarioController extends Controller
{
    protected $model;
    protected $relationships = [
        'EstadoCivil', 'HistoricoAbastecimentos', 'HistoricoCompras',
        'Fazenda', 'HistoricoTerras', 'HistoricoCompraInsumo', 'HistoricoCompraMedicamento',
        'HistoricoAnimal'
    ];
    
    public function __construct(\App\Models\Funcionario\Funcionario $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os funcionários)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $funcionarios = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            return view('pfuncionario', ['funcionarios' => $funcionarios]);
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
            $grupos = \App\Models\Funcionario\EstadoCivil::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cfuncionario', ['grupos' => $grupos, 'fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cfuncionario', ['grupos' => [], 'fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }

    // Método POST (salva o funcionário) : OK      
    public function store(Request $request)
    {        
        $funcionario = $request->only('nome', 'id_estado_civil', 'endereco_rua', 'endereco_numero',
                        'endereco_bairro', 'endereco_cidade', 'endereco_estado', 'endereco_pais',
                        'sexo', 'nascimento', 'admissao', 'cargo', 'rg', 'cpf', 'pis', 'tel_fixo',
                        'celular', 'cep', 'id_fazenda');
        //Validação
        $validator = $this->Validator($funcionario);
        if ($validator->fails()) {
            return redirect('funcionario/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        try 
        {
            $grupos = \App\Models\Funcionario\EstadoCivil::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();

            $success = $this->model->create($funcionario);

            //Alterar para retornar view
            return view('cfuncionario', ['success' => $success, 'grupos' => $grupos, 'fazendas' => $fazendas]);

        } 
        catch(\Exception $e) 
        {
            return redirect('funcionario/create')
                            ->withErrors($this->Error('Não foi possível inserir o registro.',$e))
                            ->withInput(['grupos' => [], 'fazendas' => []]);

        }
    } 

    //Método GET (retorna um funcionário específico)
    public function show($id)
    {
        try
        {
            $funcionario = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($funcionario);
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

    //Método PUT (atualiza um funcionário)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_funcionario = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_funcionario->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_funcionario
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

    //Método DELETE (deleta um funcionário específico)
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
            'nome.required'=> 'O campo nome é obrigatório',
            'nome.max'=> 'O tamanho máximo do campo nome é 100 caracteres',
            'id_fazenda.required'=> 'O campo de fazenda é obrigatório',
            'id_estado_civil.required'=> 'O campo de estado civil é obrigatório',
            'endereco_rua.required'=> 'O campo rua é obrigatório',
            'endereco_rua.max'=> 'O tamanho máximo do campo rua é 45 caracteres',
            'enderco_cidade.required'=> 'O campo cidade é obrigatório',
            'endereco_cidade.max'=> 'O tamanho máximo do campo cidade é 45 caracteres',
            'endereco_estado.required'=> 'O campo estado é obrigatório',
            'endereco_estado.max'=> 'O tamanho máximo do campo estado é 45 caracteres',
            'endereco_pais.required'=> 'O campo país é obrigatório',
            'endereco_pais.max'=> 'O tamanho máximo do campo país é 45 caracteres',
            'endereco_bairro.required'=> 'O campo bairro é obrigatório',
            'endereco_bairro.max'=> 'O tamanho máximo do campo bairro é 45 caracteres',
            'endereco_numero.required'=> 'O campo número é obrigatório',
            'endereco_numero.max'=> 'O tamanho máximo do campo número é 45 caracteres',            
            'nascimento.required'=> 'O campo nascimento é obrigatório',            
            'admissao.required'=> 'O campo admissão é obrigatório',            
            'cargo.required'=> 'O campo cargo é obrigatório',
            'cargo.max'=> 'O tamanho máximo do campo cargo é 45 caracteres',
            'rg.required'=> 'O campo RG é obrigatório',
            'rg.max'=> 'O tamanho máximo do campo RG é 45 caracteres',
            'rg.unique'=> 'RG já registrado',
            'cpf.required'=> 'O campo CPF é obrigatório',
            'cpf.max'=> 'O tamanho máximo do CPF cargo é 45 caracteres',
            'cpf.unique'=> 'CPF já registrado',
            'pis.required'=> 'O campo PIS é obrigatório',
            'pis.max'=> 'O tamanho máximo do campo PIS é 45 caracteres',
            'pis.unique'=> 'PIS já registrado',
            'tel_fixo.required'=> 'O campo telefone fixo é obrigatório',
            'tel_fixo.max'=> 'O tamanho máximo do telefone fixo cargo é 45 caracteres',
            'celular.required'=> 'O campo celular é obrigatório',
            'celular.max'=> 'O tamanho máximo do celular cargo é 45 caracteres',
            'cep.required'=> 'O campo CEP é obrigatório',
            'cep.max'=> 'O tamanho máximo do campo CEP é 45 caracteres',
        );    
        $rules = array(
            'nome'=>'required|max:100',
            'endereco_rua'=>'required|max:45',
            'cep'=>'required|max:45',
            'endereco_cidade'=>'required|max:45',
            'endereco_estado'=>'required|max:45',
            'endereco_pais'=>'required|max:45',
            'endereco_bairro'=>'required|max:45',
            'endereco_rua'=>'required|max:45',
            'endereco_numero'=>'required|max:15',
            'id_estado_civil'=>'required',
            'id_fazenda'=>'required',
            'nascimento'=>'required',
            'admissao'=>'required',
            'cargo'=>'required|max:45',
            'rg'=>'required|unique:funcionario|max:45',
            'cpf'=>'required|unique:funcionario|max:45',
            'pis'=>'required|unique:funcionario|max:45',
            'tel_fixo'=>'required|max:45',
            'celular'=>'required|max:45',
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
