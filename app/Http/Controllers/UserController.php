<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $model;
    protected $relationships = [
        'Fazendas'
    ];
    
    public function __construct(\App\User $model)
    {
        $this->model = $model;
    }

    public function GetUsers()
    {
        try
        {
            //resultados por página
            $limit = 20;
            
            $users = $this->model->orderBy('id', 'asc')
                ->with($this->relationships())
                ->where(function($query){
                    return $query
                        ->orderBy('id', 'asc');
                })
                ->paginate($limit);

            //Alterar para retornar a view mas para nível de teste ele retornará um json
            return response()->json($users);
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

    public function ShowUser($id)
    {
        try
        {
            $user = $this->model->with($this->relationships())
                                ->findOrFail($id);       

            //retornar view
            return response()->json($user);
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

    public function UpdateUser(Request $request, $id)
    {
        //tratar entrada
        try
        {
            $update_user = $this->model->findOrFail($id);            
            $dados = $request->all();

            if(isset($dados['password'])) {
                $dados['password'] = bcrypt($dados['password']);
            }

            $update_user->update($dados);
            
            //retornar view
            return response()->json([
                'status' => 'OK', 
                'item' => $update_user
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

    public function DeleteUser($id)
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

    protected function relationships()
    {
        if(isset($this->relationships)) {
            return $this->relationships;
        }

        return [];
    }
}
