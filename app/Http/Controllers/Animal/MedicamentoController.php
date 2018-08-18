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

    //Método GET (retorna os medicamentos) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $medicamentos = $this->model->orderBy('id', 'asc')
                ->with('Fazenda', 'TipoMedicamento')
                ->get();/*->paginate($limit); //limite por páginas */
            
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $tipos = \App\Models\Animal\TipoMedicamento::orderBy('nome', 'asc')->get();
                
            return view('pesquisa.pfarmacia', ['medicamentos' => $medicamentos, 'fazendas' => $fazendas, 'tipos' => $tipos]);
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pfarmacia', ['medicamentos' => [], 'fazendas' => [], 'tipo' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $tipos = \App\Models\Animal\TipoMedicamento::orderBy('nome', 'asc')->get();
        
            return view('cadastro.cfarmacia', ['fazendas' => $fazendas, 'tipos' => $tipos]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.cfarmacia', ['fazendas' => [], 'tipos' => []])
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
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Cadastro
        try 
        {
            $success = $this->model->create($medicamento);            

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

    //Método PUT (atualiza um medicamento) : OK
    public function update(Request $request, $id)
    {
        $dados = $request->only('id_tipo_medicamento', 'nome', 'obs', 'id_fazenda');
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
        //tratar entrada
        try
        {
            $update = $this->model->findOrFail($id);      

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

    //Método de validação
    protected function Validator($requisicao, $update = false){
        if($update)       
        {
            $messages = array(
                'nome.max' => 'O tamanho máximo do campo nome é 45 caracteres',
                'obs.max' => 'O tamanho máximo do campo de observações é 140 caracteres',
            );    
            $rules = array(
                'id_fazenda' => '',
                'id_tipo_medicamento' => '',
                'nome' => 'max:45',
                'obs' => 'max:140'
            );
        }
        else
        {        
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