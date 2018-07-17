 @extends('layouts.layout')
 @section('content')

<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Insumos</h3>
				@if (isset($success))
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Cadastrado!</strong> O insumo foi armazenado no celeiro.
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

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Cadastre o insumo inserindo-o nos campos abaixo:
				</div>
				<form name="register-insumos" action="{{ route('insumo.store') }}" method="post">
				{{ csrf_field() }}
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Selecione o celeiro</label>
											<select class="form-control" name="id_celeiro">
												@foreach($celeiros as $celeiro)
													<option value="{{$celeiro->id}}">{{$celeiro->nome}} | Fazenda: {{$celeiro->fazenda->nome}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Tipo de insumo</label>
											<select class="form-control" name="id_tipo_insumo">
												@foreach($tipos as $tipo)
													<option value="{{$tipo->id}}">{{$tipo->nome}}</option>
												@endforeach
											</select>
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
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@endsection