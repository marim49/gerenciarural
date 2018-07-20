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

    //Método GET (retorna as terras)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $terras = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return view('pesquisa.pterra', ['terras' => $terras]);
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

    //Método GET (retorna uma terra específica)
    public function show($id)
    {
        try
        {
            $terra = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($terra);
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

    //Método PUT (atualiza uma terra)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_terra = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_terra->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_terra
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

    //Método DELETE (deleta uma terra específica)
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
    
        return Validator::make($requisicao, $rules,$messages);        
    }

    //Método de retorno de erro : OK
    protected function Error($message, \Exception $e){
        return [
            'message' => $message.' Erro: '.$e->getMessage()
        ];
    }
}
