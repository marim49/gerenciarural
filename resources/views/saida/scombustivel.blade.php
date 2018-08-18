@extends('layouts.layout') @section('content')
<div class="container ">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Saída de combustível</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> O abastecimento foi registrado no histórico.
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
					Informações da máquina abastecida
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="abastecimento" action="{{ route('abastecimento.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select type="hidden" id="fazendas" required class="form-control" onchange="SaidaCombustivel()">
												<option value="" disabled selected>- Selecione uma fazenda -</option>												
												@foreach($fazendas as $fazenda)
												<option value="{{$fazenda}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Máquina de destino:</label>
											<select id="maquina" required class="form-control" name="id_maquina">
												<option value="" disabled selected>- Selecione uma fazenda -</option>		
											</select>
										</div>

										<div class="form-group">
											<label>Combustível:</label>
											<select id="combustivel" required class="form-control" name="id_combustivel">
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
											<label>Quantidade do abastecimento:</label>
											<input class="form-control" required name="quantidade" type="number" step=".01" placeholder="Em litros" value="{{ old('quantidade')}}"/>
										</div>										

										<div class="form-group">
											<label>Horímetro:</label>
											<input class="form-control" required name="horimetro" type="number" placeholder="Valor atual do horímetro da máquina" value="{{ old('horimetro')}}"/>
										</div>

										<div class="form-group">
											<label>Data de Abastecimento:</label>
											<input class="form-control" required name="data" type="date" placeholder="DD/MM/AAAA" value="{{ old('data')}}"/>
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