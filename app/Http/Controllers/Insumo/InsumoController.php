<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InsumoController extends Controller
{
    protected $model;
    protected $relationships = [
        'TipoInsumo', 'HistoricoTerras', 'HistoricoCompraInsumo', 'Fazenda'
    ];
    
    public function __construct(\App\Models\Insumo\Insumo $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os insumos) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $insumos = $this->model->orderBy('id', 'asc')
                ->with('TipoInsumo', 'Fazenda')
                ->get();/*->paginate($limit); //limite por páginas */
        
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
            $tipos = \App\Models\Insumo\TipoInsumo::orderBy('nome', 'asc')->get();

            return view('pesquisa.pinsumo', ['insumos' => $insumos, 'fazendas' => $fazendas, 'tipos' => $tipos]);
        
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pinsumo', ['insumos' => [], 'fazendas' => [], 'tipo' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();            
            $tipos = \App\Models\Insumo\TipoInsumo::orderBy('nome', 'asc')->get();
        
            return view('cadastro.cinsumo', ['fazendas' => $fazendas, 'tipos' => $tipos]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.cinsumo', ['fazendas' => [], 'tipos'=> []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }
    
    // Método POST (salva o insumo) : OK
    public function store(Request $request)
    {
        $insumo = $request->only('id_fazenda', 'id_tipo_insumo', 'nome');
        //Validação
        $validator = $this->Validator($insumo);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {
            $success = $this->model->create($insumo);

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

    //Método PUT (atualiza um insumo) : OK
    public function update(Request $request, $id)
    {
        $dados = $request->only('id_tipo_insumo', 'nome', 'id_fazenda');
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
            );    
            $rules = array(
                'id_fazenda' => '',
                'id_tipo_insumo' => '',
                'nome' => 'max:45'
            );
        }
        else
        {      
            $messages = array(
                'id_fazenda.required'=> 'O campo de fazenda é obrigatório',
                'id_tipo_insumo.required'=> 'O campo de tipo de insumo',
                'nome.required' => 'O campo nome é obrigatório'           ,
                'nome.max' => 'O tamanho máximo do campo nome é 45 caracteres'
            );    
            $rules = array(
                'id_fazenda'=>'required',
                'id_tipo_insumo'=>'required',
                'nome'=>'required|max:45'
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
