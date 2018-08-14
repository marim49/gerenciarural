@extends('layouts.layout') @section('content')
<div class="container">
    <!--Cabeçalho pagina-->
    <div class="col-md-12">
        <div class="row pad-botm">
            <h3 class="header-line">Home</h3>
        </div>
    </div>
    <!--/Cabeçalho pagina-->

    <!--Conteudo da pagina-->
    <div class="row">
        <div class="col-md-12">
            <div class="row pad-botm">
                @if (session()->has('registered'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Cadastrado!</strong> O novo usuário foi armazenado.
                </div>
                @endif
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card-body">
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif Você está logado!
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/Conteudo da pagina-->
</div>
</div>
@endsection