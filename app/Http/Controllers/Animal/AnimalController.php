<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazenda', 'GrupoAnimal', 'HistoricoAnimal'
    ];
    
    public function __construct(\App\Models\Animal\Animal $model)
    {
        $this->model = $model;
    }

    //Método GET (retorna os animais) : OK
    public function index()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $animais = $this->model->orderBy('id', 'asc')
                ->with('GrupoAnimal', 'Fazenda')
                ->get();/*->paginate($limit); //limite por páginas */

            $grupos = \App\Models\Animal\GrupoAnimal::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
                
            return view('pesquisa.panimal', ['animais' => $animais, 'grupos' => $grupos, 'fazendas' => $fazendas]);
        }
        catch(\Exception $e) 
        {
            return view('pesquisa.pfazenda', ['animais' => [], 'grupos' => [], 'fazendas' => []])
                            ->withErrors($this->Error('Não foi possível recuperar os registros.',$e));
        }
    }
    
    //Método GET (chama a view de criação) : OK
    public function create()
    {
        try
        {
            $grupos = \App\Models\Animal\GrupoAnimal::orderBy('nome', 'asc')->get();
            $fazendas = \App\Models\Fazenda\Fazenda::orderBy('nome', 'asc')->get();
        
            return view('cadastro.canimal', ['grupos' => $grupos, 'fazendas' => $fazendas]);
        }         
        catch(\Exception $e) 
        {          
            return view('cadastro.canimal', ['grupos' => []])
                            ->withErrors($this->Error('Houve algum erro.',$e));
        }
    }

    // Método POST (salva o animal) : OK     
    public function store(Request $request)
    {
        $animal = $request->only('nome', 'id_grupo_animal', 'id_fazenda', 'entrada', 'nascimento',
                                 'nome_mae', 'nome_pai');
        //Validação
        $validator = $this->Validator($animal);
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        //Inserção no banco
        try 
        {
            $success = $this->model->create($animal);

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
        try
        {
            $dados = $request->only('id_grupo_animal', 'nome', 'id_fazenda', 'entrada', 'nome_mae', 'nome_pai', 'nascimento');
            //Caso o nome seja o mesmo enviado
            $update = $this->model->findOrFail($id);      
            if($dados['nome'] == $update->nome)
            {                
                unset($dados['nome']);
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
                'nome.max'=> 'O tamanho máximo do campo de identificação do animal é 45 caracteres',
                'nome.unique'=> 'Já existe um animal com essa identificação cadastrado',
                'nome_mae.max'=> 'O tamanho máximo do campo de identificação da mãe é 45 caracteres',
                'nome_pai.max'=> 'O tamanho máximo do campo de identificação do pai é 45 caracteres',
                'entrada.date'=> 'O campo de entrada tem que ser do tipo data',
                'nascimento.date'=> 'O campo de nascimento não contém uma data válida',
            );    
            $rules = array(
                'id_fazenda' => '',
                'nome' => 'max:45|unique:animal',
                'nome_mae' => 'max:45',
                'nome_pai' => 'max:45',
                'nascimento' => 'date',
                'entrada' => 'date',
                'id_grupo_animal' => '',
            );
        }    
        else
        {
            $messages = array(
                'nome.required'=> 'O campo de identificação do animal é obrigatório',
                'nome.max'=> 'O tamanho máximo do campo de identificação do animal é 45 caracteres',
                'nome.unique'=> 'Já existe um animal com essa identificação cadastrado',
                'nome_mae.max'=> 'O tamanho máximo do campo de identificação da mãe é 45 caracteres',
                'nome_pai.max'=> 'O tamanho máximo do campo de identificação do pai é 45 caracteres',
                'entrada.required'=> 'O campo de entrada é obrigatório',
                'entrada.date'=> 'O campo de entrada tem que ser do tipo data',
                'nascimento.date'=> 'O campo de nascimento não contém uma data válida',
                'id_grupo_animal.required'=>'O campo de grupo do animal é obrigatório',
                'id_fazenda.required' => 'O campo de fazenda é obrigatório'
            );    
            $rules = array(
                'id_fazenda' => 'required',
                'nome'=>'required|max:45|unique:animal',
                'nome_mae'=>'max:45',
                'nome_pai'=>'max:45',
                'nascimento'=>'date',
                'entrada'=>'required|date',
                'id_grupo_animal'=>'required',
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
