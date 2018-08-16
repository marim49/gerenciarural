<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator; 

class HistoricoCompraInsumoController extends Controller
{
    protected $model;
    protected $relationships = [
        'Insumo.TipoInsumo', 'Funcionario'
    ];
    
    public function __construct(\App\Models\Insumo\HistoricoCompraInsumo $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os historicos de insumos)
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_compra_insumo = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            //return response()->json($historicos_compra_insumo);
            return view('relatorio.rcompra-insumo', ['historicos_compra_insumo' => $historicos_compra_insumo]);
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
            $fazendas = \App\Models\Fazenda\Fazenda::with('Insumos.TipoInsumo', 'Funcionarios')
                                                    ->orderBy('nome', 'asc')->get();    
            $fornecedores = \App\Fornecedor::orderBy('nome', 'asc')->get();

            return view('entrada.einsumo', ['fazendas' => $fazendas, 'fornecedores' => $fornecedores]);
        }         
        catch(\Exception $e) 
        {          
            return view('entrada.einsumo', ['fazendas' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }   
      
    //Método POST (salva uma compra de insumo) : OK 
    public function store(Request $request)
    {
        
        $compra = $request->only('id_funcionario', 'id_fornecedor', 'nota_fiscal','lote','data', 
                                  'valor', 'id_insumo', 'quantidade');
        //Validação
        $validator = $this->Validator($compra);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {   
            //criando notas
            $notas = array();
            $entrada = $request->only('id_funcionario', 'id_fornecedor', 'nota_fiscal','lote','data', 
                                        'valor');    
            $insumos = $compra['id_insumo'];
            $quantidades = $compra['quantidade'];

            for($i = 0; $i < count($quantidades); $i++){ 
                $insumo = \App\Models\Insumo\Insumo::find($insumos[$i]); 
                if($insumo){
                        $insumo->increment('quantidade', $quantidades[$i]);
                        $compra  = array_merge($entrada,['id_insumo' => $insumos[$i], 'quantidade' => $quantidades[$i]]);
                        $success = $this->model->create($compra);                
                }
                else{
                    throw new \Exception('Não foi possível encontrar o insumo no banco de dados');
                }
            }
                
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

    //Método GET (retorna uma compra de insumo específico)
    public function show($id)
    {
        try
        {
            $historico_compra_insumo = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($historico_compra_insumo);
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

    //Método PUT (atualiza uma compra de insumo)
    public function update(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_historico_compra_insumo = $this->model->findOrFail($id);            
            $dados = $request->all();

            $update_historico_compra_insumo->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_historico_compra_insumo
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

    //Método DELETE (deleta uma compra de insumo específica)
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

    //Método de retorno de relacionamentos : OK
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
            'id_insumo.required'=>'O campo de insumo é obrigatório',
            'id_insumo.*.required'=>'É necessário selecionar um insumo na linha da tabela',
            'id_insumo.*.distinct' => 'Existe insumos duplicados na tabela',
            'id_funcionario.required'=>'O campo de funcionário é obrigatório',
            'id_fornecedor.required'=>'O campo de fornecedor é obrigatório',
            'data.required'=>'O campo de data é obrigatório',
            'data.date'=>'O campo de data está em formato inválio',
            'lote.max'=>'O campo de lote só pode ter no máximo 45 caracteres',
            'quantidade.required'=>'O campo de quantidade é obrigatório',
            'quantidade.*.min'=>'O campo de quantidade não pode ser menor ou igual a zero',
            'quantidade.*.numeric'=>'O campo de quantidade só pode ter entradas numéricas',
            'quantidade.*.required'=>'As linhas da tabela devem ter a quantidade preenchida',
            'nota_fiscal.required'=>'O campo de nota fiscal é obrigatório',
            'nota_fiscal.max'=>'O campo de nota fiscal só pode ter no máximo 45 caracteres',
            'valor.required'=>'O campo de valor é obrigatório',
            'valor.max'=>'O campo de valor só pode ter no máximo 45 caracteres',
            'valor.numeric'=>'O campo valor só pode ter entradas numéricas',
        );    
        $rules = array(
            'id_insumo'=>'required',
            "id_insumo.*"  => "required|distinct",
            'id_funcionario'=>'required',
            'id_fornecedor'=>'required',
            'data'=>'required|date',
            'lote'=>'max:45',
            'quantidade'=>'required',
            'quantidade.*'=>'required|numeric|min:1',
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