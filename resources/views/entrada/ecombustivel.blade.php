 @extends('layouts.layout') @section('content')
<div class="container ">
	<!--Cabeçalho pagina-->
	<div class="col-md-12"> 
		<div class="row pad-botm">
			<h3 class="header-line">Entrada de combustível</h3>
			@if (isset($success))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> A entrada de combustível foi registrada no histórico.
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
					Armazenar
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="armazenar" action="{{ route('compra-combustivel.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select type="hidden" id="fazendas" class="form-control" onchange="EntradaCombustivel()">
												<option value="" selected>- Selecione Fazenda -</option>
												@foreach($fazendas as $fazenda)
												<option value="{{$fazenda}}">{{$fazenda->nome}}</option>
												@endforeach
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
											<input class="form-control" name="quantidade" type="numeric" placeholder="Em litros" />
										</div>

										<div class="form-group">
											<label>Data de Abastecimento:</label>
											<input class="form-control" name="data" type="date" placeholder="DD/MM/AAAA" />
										</div>

										<div class="form-group">
											<label>Lote:</label>
											<input class="form-control" name="lote" placeholder="Lote de compra" />
										</div>

										<div class="form-group">
											<label>Nota fiscal:</label>
											<input class="form-control" name="nota_fiscal" placeholder="Nota fiscal da compra" />
										</div>

										<div class="form-group">
											<label>Valor:</label>
											<input class="form-control" name="valor" type="numeric" placeholder="Valor da compra" />
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