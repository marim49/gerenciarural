

@extends('layouts.layout')

@section('content')

<div class="container">
		<div class="col-md-12">
			<div class="row pad-botm">
				<h3 class="header-line">Cadastrar Máquinas</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Cadastre a máquina inserindo-a nos campos abaixo
					</div>
					<form name="register-maquinas" action="../../controller/cadastro/maquinas/maquinas.php" method="post">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">

									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label>Nome do máquina:</label>
												<input class="form-control" name="nome_maquina" type="text" placeholder="" />
											</div>
										</div>
										<div class="col-md-7">
											
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Data de Compra:</label>
												<input class="form-control" name="data_compra" type="date" placeholder="DD/MM/AAAA" />
											</div>
										</div>
										<div class="col-md-9">

										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Número da nota fiscal:</label>
												<input class="form-control" name="nota_fisc" type="text" placeholder="" />
											</div>
										</div>
										<div class="col-md-9">

										</div>
									</div>

									<div class="right-div">
										<button type="submit" class="btn btn-info pull-right">Salvar </button>
									</div>
									<div class="right-div">
										<button type="submit" class="btn btn-info pull-right">Limpar </button>
									</div>

								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
@endsection