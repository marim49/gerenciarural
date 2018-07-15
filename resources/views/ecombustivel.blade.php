 @extends('layouts.layout') 
 @section('content')
<div class="container ">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Entrada de combustível</h3>
			@if (isset($success))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> O abastecimento foi registrado no histórico.
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
					Abastecer
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="abastecimento" action="{{ route('abastecer') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select id="fazendas" class="form-control" onchange="EntradaCombustivel()" name="id_fazenda">
												@foreach($fazendas as $fazenda)
												<option value="{{$fazenda->Combustiveis}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Máquina:</label>
											<select id="maquina" class="form-control" name="id_maquina">
											</select>
										</div>

										<div class="form-group">
											<label>Combustível:</label>
											<select id="combustivel" class="form-control" name="id_combustivel">
											</select>
										</div>

										<div class="form-group">
											<label>Funcionário:</label>
											<select id="funcionario" class="form-control" name="id_funcionario">
											</select>
										</div>

										<div class="form-group">
											<label>Quantidade a abastecer:</label>
											<input class="form-control" type="text" placeholder="Em litros" />
										</div>

										<div class="form-group">
											<label>Data de Abastecimento:</label>
											<input class="form-control" name="data_abast" type="date" placeholder="DD/MM/AAAA" />
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