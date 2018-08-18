@extends('layouts.layout') @section('content')

<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Terra</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Cadastrada!</strong> A terra foi armazenada.
			</div>
			@endif @if ($errors->any()) @foreach ($errors->all() as $error)
			<div class="alert alert-warning alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Ops!</strong> {{$error}}.
			</div>
			@endforeach @endif
		</div>
	</div>
	<!--/Cabeçalho pagina-->

	<!--Conteudo da pagina-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Cadastrar terra
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="register-terra" action="{{ route('terra.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">

									<div class="col-md-8">
										<div class="form-group">
											<label>Fazenda: *</label>
											<select class="form-control" name="id_fazenda">
												@foreach($fazendas as $fazenda)												
													@if (old('id_fazenda') == $fazenda->id)
													<option value="{{$fazenda->id}}" selected>{{$fazenda->nome}}</option>
													@else
													<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-md-8">
										<div class="form-group">
											<label>Nome da terra: *</label>
											<input class="form-control" type="text" name="nome" required maxlength="45" value="{{old('nome')}}"/>
										</div>
									</div>

									<div class="col-md-8">
										<div class="form-group">
											<label>Área:</label>
											<input class="form-control" type="text" required maxlength="45" name="area" value="{{ old('area')}}"/>
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