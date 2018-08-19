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

    //Método GET (retorna os funcionários) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $funcionarios = $this->model->orderBy('id', 'asc')
                ->with('Fazenda','EstadoCivil')
                ->get();/*->paginate($limit); //limite por páginas */

            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $grupos = \App\Models\Funcionario\EstadoCivil::orderBy('nome', 'asc')->get();
            
               // return response()->json($funcionarios);
            return view('pesquisa.pfuncionario', ['funcionarios' => $funcionarios,
            'fazendas' => $fazendas, 'grupos' => $grupos]);
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pfuncionario', ['funcionarios' => [], 'fazendas' => [], 'grupos' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    } 

    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $grupos = \App\Models\Funcionario\EstadoCivil::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cadastro.cfuncionario', ['grupos' => $grupos, 'fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.cfuncionario', ['grupos' => [], 'fazendas' => []])
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
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Cadastro
        try 
        {

            $success = $this->model->create($funcionario);

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

    //Método PUT (atualiza um funcionário) : OK
    public function update(Request $request, $id)
    {
        try
        {            
            $dados = $request->only('id_estado_civil', 'id_fazenda', 'nome', 'endereco_rua', 'endereco_bairro',
            'endereco_numero', 'endereco_cidade', 'endereco_estado', 'pais', 'sexo', 'nascimento', 'admissao',
            'cargo', 'rg', 'pis', 'cpf', 'tel_fixo', 'celular', 'cep');

            //Caso o seja enviado os mesmos valores
            $update = $this->model->findOrFail($id);      
            if($dados['rg'] == $update->rg)
            {                
                unset($dados['rg']);
            }
            if($dados['pis'] == $update->pis)
            {                
                unset($dados['pis']);
            }
            if($dados['cpf'] == $update->cpf)
            {                
                unset($dados['cpf']);
            }

            foreach ($dados as $key => $value) {
                if ($value == null) {
                    unset($dados[$key]);
                }
            }
            //Validação
            $validator = $this->Validator($dados, true);
            if ($validator->fails()) {
                return redirect()
                                ->back()
                                ->withErrors($validator)
                                ->withInput();
            }
            //Update
            $update->update($dados);
            
            return redirect()
                            ->back()
                            ->with('success',$update); 
        }
        catch(\Exception $e) 
        {
            return redirect()
                            ->back()
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
    protected function Validator($requisicao, $update = false){        
        if($update)
        {
            $messages = array(
                'nome.max'=> 'O tamanho máximo do campo nome é 100 caracteres',
                'endereco_rua.max'=> 'O tamanho máximo do campo rua é 45 caracteres',
                'endereco_cidade.max'=> 'O tamanho máximo do campo cidade é 45 caracteres',
                'endereco_estado.max'=> 'O tamanho máximo do campo estado é 45 caracteres',
                'endereco_pais.max'=> 'O tamanho máximo do campo país é 45 caracteres',
                'endereco_bairro.max'=> 'O tamanho máximo do campo bairro é 45 caracteres',
                'endereco_numero.max'=> 'O tamanho máximo do campo número é 45 caracteres',  
                'cargo.max'=> 'O tamanho máximo do campo cargo é 45 caracteres',
                'rg.max'=> 'O tamanho máximo do campo RG é 45 caracteres',
                'rg.unique'=> 'RG já registrado',
                'cpf.max'=> 'O tamanho máximo do CPF cargo é 45 caracteres',
                'cpf.unique'=> 'CPF já registrado',
                'pis.max'=> 'O tamanho máximo do campo PIS é 45 caracteres',
                'pis.unique'=> 'PIS já registrado',
                'tel_fixo.max'=> 'O tamanho máximo do telefone fixo cargo é 45 caracteres',
                'celular.max'=> 'O tamanho máximo do celular cargo é 45 caracteres',
                'cep.max'=> 'O tamanho máximo do campo CEP é 45 caracteres',
                'nascimento.date'=> 'O campo de nascimento só pode ter entradas no formato de data',
                'admissao.date'=> 'O campo de admissão só pode ter entradas no formato de data',
            );    
            $rules = array(
                'nome'=>'max:100',
                'endereco_rua'=>'max:45',
                'cep'=>'max:45',
                'endereco_cidade'=>'max:45',
                'endereco_estado'=>'max:45',
                'endereco_pais'=>'max:45',
                'endereco_bairro'=>'max:45',
                'endereco_numero'=>'max:15',
                'id_estado_civil'=>'',
                'id_fazenda'=>'',
                'nascimento'=>'date',
                'admissao'=>'date',
                'cargo'=>'max:45',
                'rg'=>'unique:funcionario|max:45',
                'cpf'=>'unique:funcionario|max:45',
                'pis'=>'unique:funcionario|max:45',
                'tel_fixo'=>'max:45',
                'celular'=>'max:45',
            );
        }
        else
        {
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
                'nascimento.date'=> 'O campo de nascimento só pode ter entradas no formato de data',
                'admissao.date'=> 'O campo de admissão só pode ter entradas no formato de data',      
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
                'endereco_numero'=>'required|max:15',
                'id_estado_civil'=>'required',
                'id_fazenda'=>'required',
                'nascimento'=>'date|required',
                'admissao'=>'date|required',
                'cargo'=>'required|max:45',
                'rg'=>'required|unique:funcionario|max:45',
                'cpf'=>'required|unique:funcionario|max:45',
                'pis'=>'required|unique:funcionario|max:45',
                'tel_fixo'=>'required|max:45',
                'celular'=>'required|max:45',
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