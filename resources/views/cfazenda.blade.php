 @extends('layouts.layout')
 @section('content')

<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Fazenda</h3>
			@if (isset($success))
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Cadastrada!</strong> A fazenda foi armazenada.
				</div>
			@endif
			@if ($errors->any())
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Ops!</strong> {{$errors->first()}}.
				</div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Insira os dados para cadastrar uma fazenda:
				</div>
				<form name="register-fazenda" action="{{ route('fazenda.store')}}" method="post">
					{{ csrf_field() }}
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<form role="form">
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label>Nome da fazenda:</label>
												<input class="form-control" type="text" name="nome" placeholder="Insira aqui o nome da sua fazenda" />
											</div>
										</div>
										<div class="col-md-4">

										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label>Telefone:</label>
												<input class="form-control" type="text" name="telefone" placeholder="(__)____-____" maxlength="16" />
											</div>
										</div>
										<div class="col-md-7">

										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>CEP:</label>
												<input class="form-control" type="text" name="end_cep" placeholder="CEP" />
											</div>
										</div>
										<div class="col-md-4">

										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>Rua:</label>
												<input class="form-control" type="text" name="end_rua" placeholder="" />
											</div>
										</div>
										<div class="col-md-4">
										<label>Nº:</label>
												<input class="form-control" type="text" name="end_numero" placeholder="" />
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>Bairro:</label>
												<input class="form-control" type="text" name="end_bairro" placeholder="" />
											</div>
										</div>
										<div class="col-md-4">
										<label>Estado:</label>
												<input class="form-control" type="text" name="end_estado" placeholder="" />
										</div>

										<div class="col-md-8">
											<div class="form-group">
												<label>Cidade:</label>
												<input class="form-control" name="end_cidade" type="text" placeholder="" />
											</div>
										</div>

										<div class="col-md-4">
										<label>País:</label>
											<select class="form-control" name="end_pais">
												<option value="Argentina">Argentina</option>
												<option value="Brasil" selected>Brasil</option>
												<option value="Canadá">Canadá</option>
												<option value="Chile">Chile</option>	
												<option value="Espanha">Espanha</option>
												<option value="Estados Unidos">Espanha</option>	
												<option value="França">França</option>
												<option value="Itália">Itália</option>										
												<option value="Portugual">Portugual</option>
											</select>
										</div>
										
										
									</div>
									<div class="right-div">
										<button type="submit" class="btn btn-info pull-right">Salvar </button>
									</div>
									<div class="right-div">
										<button type="reset" class="btn btn-info pull-right">Limpar </button>
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