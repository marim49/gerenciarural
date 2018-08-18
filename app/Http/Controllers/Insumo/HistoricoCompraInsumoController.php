<?php

namespace App\Http\Controllers\Insumo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth;

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

    //Método GET (retorna os historicos de insumos) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $historicos_compra_insumo = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->paginate($limit);

            return view('relatorio.rcompra-insumo', ['historicos_compra_insumo' => $historicos_compra_insumo]);
        }
        catch(\Exception $e) 
        {
            return view('relatorio.rcompra-insumo', ['historicos_compra_insumo' => []])
            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
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

    //Método DELETE (cancela uma compra de insumo específica) : OK
    public function destroy(Request $request, $id)
    {
        $resposta = $request->only('motivo', 'cancelado');
        //Validação
        $validator = $this->Validator($resposta, true);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        } 
        try
        {
            $resposta = array_merge($resposta, ['id_user_cancelou' => Auth::user()->id]);
            $historico_compra = $this->model->findOrFail($id);                   
            $insumo = \App\Models\Insumo\Insumo::find($historico_compra->id_insumo);
            
            if($insumo){
                if($insumo->quantidade < $historico_compra->quantidade){                    
                    throw new \Exception('A quantidade em estoque é menor que a quantidade a ser cancelada,
                    provavelmete existe alguma operação de saída irregular, cancele-a e tente novamente');
                }
                $insumo->decrement('quantidade', $historico_compra->quantidade);
                $historico_compra->update($resposta);
            }
            else{
                throw new \Exception('Não foi possível encontrar o insumo no banco de dados');
            }              
            
            return redirect()
                            ->back()
                            ->with('success',$historico_compra);
        }
        catch(\Exception $e) 
        {
            return redirect()
                            ->back()
                            ->withErrors($this->Error('Não foi possível atualizar o registro.',$e))
                            ->withInput(); 
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
    protected function Validator($requisicao, $delete = false){           
        if($delete)
        {
            $messages = array(
                'motivo.required'=> 'O campo de motivo é obrigatório',
                'motivo.max'=>'O tamanho máximo do campo de motivo é 100 caracteres',
                'cancelado.required'=>'A operação não funcionou',
            );    
            $rules = array(
                'motivo'=>'required|max:100',
                'cancelado'=>'required',
            );
        }
        else
        {     
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