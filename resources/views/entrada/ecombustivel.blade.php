 @extends('layouts.layout') @section('content')
<div class="container ">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Entrada de combustível</h3>
			@if (session()->has('success'))
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
											<select id="fazendas" name="id_fazenda" class="form-control" onchange="EntradaCombustivel()">
												<option value="" selected>- Selecione a Fazenda -</option>
												@foreach($fazendas as $fazenda)
													<option data-id="{{$fazenda}}" value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Funcionário:</label>
											<select id="funcionario" class="form-control" name="id_funcionario">
											</select>
										</div>

										<div class="form-group">
											<label>Fornecedor:</label>												
											<select name="id_fornecedor" class="form-control">									
												<option value="" selected>- Selecione o Fornecedor -</option>
												@foreach($fornecedores as $fornecedor)
													@if (old('id_fornecedor') == $fornecedor->id)
													<option value="{{$fornecedor->id}}" selected>{{$fornecedor->nome}}</option>
													@else
													<option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
													@endif
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Quantidade:</label>
											<input class="form-control" name="quantidade" type="numeric" placeholder="Em litros" value="{{ old('quantidade')}}"/>
										</div>

										<div class="form-group">
											<label>Data da compra:</label>
											<input class="form-control" name="data" type="date" placeholder="DD/MM/AAAA" value="{{ old('data')}}"/>
										</div>

										<div class="form-group">
											<label>Lote:</label>
											<input class="form-control" name="lote" placeholder="Lote de compra" maxlength="45" value="{{ old('lote')}}"/>
										</div>

										<div class="form-group">
											<label>Nota fiscal:</label>
											<input class="form-control" name="nota_fiscal" placeholder="Nota fiscal da compra" maxlength="45" value="{{ old('nota_fiscal')}}"/>
										</div>

										<div class="form-group">
											<label>Valor:</label>
											<input class="form-control" name="valor" type="numeric" placeholder="Valor da compra" value="{{ old('valor')}}"/>
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