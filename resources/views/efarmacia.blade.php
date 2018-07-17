 @extends('layouts.layout') @section('content')
<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Entrada Farmácia</h3>			
			@if (isset($success))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> A entrada de medicamento foi registrada no histórico.
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
					Farmácia
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="armazenar" action="{{ route('compra-medicamento.store') }}" method="post">
							{{ csrf_field() }}
								<div class="row">								
									<div class="col-md-8">
									
										<div class="form-group">
											<label>Fazenda:</label>
											<select type="hidden" id="fazendas" class="form-control" onchange="EntradaMedicamento()">
												<option value="" selected>- Selecione Fazenda -</option>
												@foreach($fazendas as $fazenda)
												<option value="{{$fazenda}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Medicamento:</label>
											<select id="medicamento" class="form-control" name="id_medicamento">
											</select>
										</div>

										<div class="form-group">
											<label>Funcionário:</label>
											<select id="funcionario" class="form-control" name="id_funcionario">
											</select>
										</div>

										<div class="form-group">
											<label>Data da Compra:</label>
											<input class="form-control" name="data" type="date" placeholder="DD/MM/AAAA" />
										</div>

										<div class="form-group">
											<label>Lote:</label>
											<input class="form-control" type="text" name="lote" placeholder="Número do lote" />
										</div>

										<div class="form-group">
											<label>Quantidade do Medicamento ( ML ):</label>
											<input class="form-control" type="text" name="quantidade" placeholder="Em Ml" />
										</div>

										<div class="form-group">
											<label>Nota Fiscal:</label>
											<input class="form-control" type="text" name="nota_fiscal" placeholder="" />
										</div>

										<div class="form-group">
											<label>Valor:</label>
											<input class="form-control" type="text" name="valor" placeholder="Em R$" />
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