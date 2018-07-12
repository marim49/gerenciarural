 @extends('layouts.layout') @section('content')

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
										<div class="col-md-5">
											<div class="form-group">
												<label>Telefone</label>
												<input class="form-control" type="text" name="telefone" placeholder="(__)____-____" maxlength="10" />
											</div>
										</div>
										<div class="col-md-7">

										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>CEP</label>
												<input class="form-control" type="text" name="CEP" placeholder="CEP" />
											</div>
										</div>
										<div class="col-md-4">

										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>Rua</label>
												<input class="form-control" type="text" name="rua" placeholder="" />
											</div>
										</div>
										<div class="col-md-4">
										<label>Nº</label>
												<input class="form-control" type="text" name="numero" placeholder="" />
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>Bairro</label>
												<input class="form-control" type="text" name="bairro" placeholder="" />
											</div>
										</div>
										<div class="col-md-4">

										</div>

										<div class="col-md-8">
											<div class="form-group">
												<label>Cidade:</label>
												<input class="form-control" name="cidade" type="text" placeholder="" />
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