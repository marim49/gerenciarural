<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Apaga isso depois
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function Teste(){
        $users = User::find(2)->first();

        
        return view('pfuncionario')->with('gatao',$users);
        //não lembro se é bem isso tem outra forma mas é mais complexo, acessando direto eu não sei
        //teria que fazer um controller mais especifico mas <continuemos ...
    }
}
