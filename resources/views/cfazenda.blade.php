

@extends('layouts.layout')

@section('content')

<div class="container">
		<div class="col-md-12">
			<div class="row pad-botm">
				<h3 class="header-line">Cadastrar Fazenda</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Cadastre as fazendas aqui
					</div>
					<form name="register-fazenda" action="../../controller/cadastro/fazenda/fazenda.php" method="post">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<form role="form">
										<div class="row">
											<div class="col-md-8">
												<div class="form-group">
													<label>Nome da fazenda:</label>
													<input class="form-control" type="text" name="nome_fazenda" placeholder="Insira aqui o nome da sua fazenda" />
												</div>
											</div>
											<div class="col-md-4">

											</div>
										</div>
										<div class="row">
											<div class="col-md-8">
												<div class="form-group">
													<label>Localização</label>
													<input class="form-control" type="text" name="localizacao" placeholder="Insira aqui a localização da sua fazenda" />
												</div>
											</div>
											<div class="col-md-4">

											</div>
										</div>
										<div class="right-div">
											<button type="submit" class="btn btn-info pull-right">Salvar </button>
										</div>
										<div class="right-div">
											<button type="submit" class="btn btn-info pull-right">Limpar </button>
										</div>
									</form>
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