<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InsumoController extends Controller
{
    protected $model;
    protected $relationships = [
        'TipoInsumo', 'HistoricoTerras', 'HistoricoCompraInsumo', 
    ];
    
    public function __construct(\App\Models\Insumo\Insumo $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os insumos)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $insumos = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return view('pesquisa.pinsumo', ['insumos' => $insumos]);
        
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

    //Método GET (retorna um insumo específico)
    public function show($id)
    {
        try
        {
            $insumo = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($insumo);
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

    //Método PUT (atualiza um insumo)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_insumo = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_insumo->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_insumo
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

    //Método DELETE (deleta um insumo específico)
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
    
        return Validator::make($requisicao, $rules,$messages);        
    }

    //Método de retorno de erro : OK
    protected function Error($message, \Exception $e){
        return [
            'message' => $message.' Erro: '.$e->getMessage()
        ];
    }
}
