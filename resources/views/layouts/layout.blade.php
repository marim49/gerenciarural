<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="" />
<meta name="author" content="" />
<!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
<title>Gerência rural</title>
<!-- BOOTSTRAP CORE STYLE  -->
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
<!-- FONT AWESOME STYLE  -->
<link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" />
<!-- CUSTOM STYLE  -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<!-- DATATABLE STYLE  -->
<link href="{{ asset('js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<!-- GOOGLE FONT -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<!-- SIDEBAR -->
<link href="{{ asset('css/sidebar/style.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
				<button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn navbar-toggle">
                    <i class="glyphicon glyphicon-align-left"></i>
                    <span>Toggle Sidebar</span>
                </button>

                <a class="navbar-brand" href="../../index.php">

                    <img src="{{ asset('img/admdeterras2.png') }}" width="50%" />
                </a>

            </div>

            <div class="right-div">
                <a href="../../controller/account/deslogar.php" class="btn btn-primary pull-right">Sair</a>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
        <div class="wrapper">
            <!-- Sidebar Holder -->
			
            <nav id="sidebar">
                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="../../index.php">
                            <i class="glyphicon glyphicon-home"></i>
                            Página inicial
                        </a>
					</li>
			
                    
                    
                    <li>
					
					<a href="#cadastrar"  data-toggle="collapse">
						<i class="glyphicon glyphicon-list-alt"></i>
						Cadastrar 
						<i class="fa fa-angle-down"></i>
					</a>
                    <ul class="collapse list-unstyled" id="cadastrar">
                        <li><a href="{{ url('cadastro/fazenda') }}"> Fazenda</a></li>
                         <li><a href="{{ url('cadastro/funcionario') }}"> Funcionários</a></li>
                         <li><a href="{{ url('cadastro/animal') }}">      
                         Animais</a></li>
                         <li><a href="{{ url('cadastro/insumo') }}">      
                         Insumos</a></li>
                         <li role="presentation"><a href="{{ url('cadastro/farmacia') }}">      
                        Farmácia</a></li>
                        <li role="presentation"><a href="{{ url('cadastro/maquina') }}">      
                        Máquinas</a></li>
                    </ul>
					
					</li>
					<li>
					<a href="#pesquisar"  data-toggle="collapse">
						<i class="glyphicon glyphicon-search"></i>
						Pesquisar 
						<i class="fa fa-angle-down"></i>
					</a>
						<ul class="collapse list-unstyled" id="pesquisar">
							<li><a href="https://gerenciarural.herokuapp.com/pesquisar/fazenda/pesquisar.php"> Fazenda</a></li>
							<li><a href="https://gerenciarural.herokuapp.com/pesquisar/funcionarios/pesquisar.php"> Funcionários</a></li>
							<li><a href="https://gerenciarural.herokuapp.com/pesquisar/animais/pesquisar.php">      
							Animais</a></li> 
							<li role="presentation"><a href="#	">      
							Tanque</a></li>
							<li><a href="https://gerenciarural.herokuapp.com/pesquisar/insumos/pesquisar.php">      
							Insumos</a></li>
							<li role="presentation"><a href="https://gerenciarural.herokuapp.com/pesquisar/farmacia/pesquisar.php">      
							Farmácia</a></li>
							<li role="presentation"><a href="https://gerenciarural.herokuapp.com/pesquisar/maquinas/pesquisar.php">      
							Máquinas</a></li>
						</ul>
					
					</li>
                    <li>
                        <a href="https://gerenciarural.herokuapp.com/cadastro/abastecertanque/cadastrar.php">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                            Abastecer o tanque
                        </a>
                    </li>
                    <li>
                        <a href="https://gerenciarural.herokuapp.com/cadastro/retiracombustivel/cadastrar.php">
                            <i class="glyphicon glyphicon-road"></i>
                            Retirar combustível
                        </a>
                    </li>
					<li>
					<a href="#">
                            <i class="glyphicon glyphicon-book"></i>
                            Editar dados
                        </a>
					</li>
                </ul>
                </ul>
            </nav>
            @yield('content')
</body>
     
<footer>
		     <!-- CONTENT-WRAPPER SECTION END-->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                   <center> </b>TECO adm. de terras &copy; 2018<div class="center"></div> </center> 
                </div>

            </div>
        </div>
    </section>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="{{ asset('js/jquery-1.10.2.js') }}"></script>
	<!-- DATATABLE SCRIPTS  -->
    <script src="{{ asset('js/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables/dataTables.bootstrap.js') }}"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="{{ asset('js/bootstrap.js') }}"></script>
	  <!-- CUSTOM SCRIPTS  -->
    <script src="{{ asset('js/custom.js') }}"></script>
	<script src="{{ asset('js/imprimir/imprimir.js') }}"></script>
	<script src="{{ asset('js/notificacao/sweet_alert.min.js') }}"></script>
		</footer>
    
</html>
