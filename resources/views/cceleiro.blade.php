

@extends('layouts.layout')

@section('content')
<div class="container">
		<!--Cabeçalho pagina-->
		<div class="col-md-12">
			<div class="row pad-botm">
				<h3 class="header-line">Celeiro</h3>				
				@if (isset($success))
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Cadastrado!</strong> O celeiro foi armazenado.
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
						Cadastrar celeiro
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
							
								<form name="register-celeiro" action="{{ route('celeiro.store') }}" method="post">
								{{ csrf_field() }}
									<div class="row">

										<div class="col-md-8">
											<div class="form-group">
												<label>Fazenda:</label>
												<select class="form-control" name="id_fazenda">
												@foreach($fazendas as $fazenda)
													<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
												@endforeach
												</select>
											</div>										
										</div>

										<div class="col-md-8">
											<div class="form-group">
												<label>Nome do celeiro:</label>
												<input class="form-control" type="text" name="nome" placeholder="" />
											</div>
										</div>

										<div class="col-md-4">

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