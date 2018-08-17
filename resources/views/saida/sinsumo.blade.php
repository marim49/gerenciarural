 @extends('layouts.layout') @section('content')
<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Saída de Insumo</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> O uso do insumo foi registrada no histórico.
			</div>
			@endif @if ($errors->any())
			<div class="alert alert-warning alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Ops!</strong> {{$errors->first()}}.
			</div>
			@endif
		</div>
	</div>
	<!--/Cabeçalho pagina-->

	<!--Conteudo da pagina-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Informações da terra de destino do insumo
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="plantio" action="{{ route('plantio.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select type="hidden" required id="fazendas" class="form-control" onchange="SaidaInsumo()">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
												@foreach($fazendas as $fazenda)
												<option value="{{$fazenda}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Terra:</label>
											<select id="terra" required class="form-control" name="id_terra">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Insumo:</label>
											<select id="insumo" required class="form-control" name="id_insumo">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Funcionário:</label>
											<select id="funcionario" required class="form-control" name="id_funcionario">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Data:</label>
											<input class="form-control" required name="data" type="date" placeholder="DD/MM/AAAA" value="{{ old('data')}}" />
										</div>

										<div class="form-group">
											<label>Quantidade:</label>
											<input class="form-control" required name="quantidade" type="number" placeholder="Ex.: 1, 3, 7 ..." value="{{ old('quantidade')}}"
											/>
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
</div>
</div>
@endsection