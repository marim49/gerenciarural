 @extends('layouts.layout')
 @section('content')

<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Fornecedor</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Cadastrado!</strong> O fornecedor foi armazenado.
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
					Insira os dados para cadastrar um fornecedor:
				</div>

				<form name="register-fornecedor" action="{{ route('fornecedor.store')}}" method="post">
					{{ csrf_field() }}
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">

								<div class="col-md-8">
									<div class="form-group">
										<label>Nome: *</label>
										<input class="form-control" type="text" name="nome" placeholder="Insira aqui o nome do fornecedor" maxlength="45" value="{{ old('nome')}}"/>
									</div>
								</div>

								<div class="col-md-8">
									<div class="form-group">
										<label>Telefone: *</label>
										<input class="form-control" type="text" name="telefone" placeholder="(__)____-____" maxlength="45" value="{{ old('telefone')}}"/>
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