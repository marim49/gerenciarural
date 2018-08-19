<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TerraController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'HistoricosTerras'
    ];
    
    public function __construct(\App\Models\Insumo\Terra $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna as terras) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $terras = $this->model->orderBy('id', 'asc')
                ->with('Fazenda')
                ->get();/*->paginate($limit); //limite por páginas */
                $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();

            return view('pesquisa.pterra', ['terras' => $terras, 'fazendas' => $fazendas]);
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pterra', ['terras' => [], 'fazendas' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cadastro.cterra', ['fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.cterra', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }

    // Método POST (salva a terra) : OK
    public function store(Request $request)
    {
        $terra = $request->only('nome', 'area', 'id_fazenda');
        //Validação
        $validator = $this->Validator($terra);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {
            $success = $this->model->create($terra);

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

    //Método PUT (atualiza uma terra) : OK
    public function update(Request $request, $id)
    {
        $dados = $request->only('id_fazenda', 'nome', 'area');
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
       
    //Método de validação : OK
    protected function Validator($requisicao, $update = false){ 
        if($update)       
        {
            $messages = array(
                'nome.max' => 'O tamanho máximo do campo nome é 45 caracteres',
                'area.max' => 'O tamanho máximo do area de observações é 45 caracteres',
            );    
            $rules = array(
                'id_fazenda' => '',
                'nome' => 'max:45',
                'area' => 'max:45'
            );
        }
        else
        {        
            $messages = array(
                'id_fazenda.required'=> 'O campo de identificação da fazenda é obrigatório',
                'nome.required'=> 'O campo nome é obrigatório',
                'nome.max'=> 'O tamanho máximo do campo nome é 45 caracteres',
                'area.max'=> 'O tamanho máximo do campo área é 45 caracteres',
            );    
            $rules = array(
                'nome'=>'required|max:45',
                'id_fazenda'=>'required',
                'area'=> 'max:45',
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