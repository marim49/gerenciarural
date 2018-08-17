 @extends('layouts.layout') @section('content')
<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Tipo de Insumo</h3>
				@if (isset($success))
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Cadastrado!</strong> O tipo de insumo foi armazenado.
					</div>
				@endif
				@if ($errors->any())
					@foreach ($errors->all() as $error)
					<div class="alert alert-warning alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Ops!</strong> {{$error}}.
					</div>
					@endforeach
				@endif
		</div>
	</div>
	<!--/Cabeçalho pagina-->

	<!--Conteudo da pagina-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Insira os dados para cadastrar um tipo de insumo:
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="register-tipoinsumo" action="{{ route('tipoinsumo.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Nome:</label>
											<input class="form-control" type="text" name="nome" required placeholder="Insira aqui o nome do tipo do insumo" maxlength="45" value="{{ old('nome')}}"/>
										</div>
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
			</div>
		</div>
	</div>
	<!--/Conteudo da pagina-->
</div>
</div>
@endsection