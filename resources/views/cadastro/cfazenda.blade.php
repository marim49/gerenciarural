 @extends('layouts.layout')
 @section('content')

<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Fazenda</h3>
			@if (session()->has('success'))
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

								<div class="col-md-8">
									<div class="form-group">
										<label>Nome da fazenda: *</label>
										<input class="form-control" type="text" name="nome" placeholder="Insira aqui o nome da sua fazenda" maxlength="100" value="{{ old('nome')}}"/>
									</div>
								</div>

								<div class="col-md-5">
									<div class="form-group">
										<label>Localidade:</label>
										<input class="form-control" type="text" name="localidade" placeholder="Insira aqui o local da sua fazenda" maxlength="45" value="{{ old('localidade')}}"/>
									</div>
								</div>

							</div>

							<div class="right-div">
								<button type="submit" class="btn btn-info pull-right">Salvar </button>
							</div>
							<div class="right-div">
								<button type="reset" class="btn btn-info pull-right">Limpar </button>
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