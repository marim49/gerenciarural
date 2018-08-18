 @extends('layouts.layout') @section('content')
<div class="container ">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Revisão de Máquina</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> A entrada de revisão foi registrada.
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
					Dados sobre a revisão
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="armazenar" action="{{ route('revisao.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select id="fazendas" name="id_fazenda" required class="form-control" onchange="Maquinas()">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
												@foreach($fazendas as $fazenda)
													<option data-id="{{$fazenda}}" value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Funcionário:</label>
											<select id="funcionario" required class="form-control" name="id_funcionario">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Máquina:</label>
											<select id="maquina" required class="form-control" name="id_maquina">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Problema:</label>
											<textarea class="form-control" name="problema" required maxlength="190" style="resize: vertical"
											placeholder="Motivo da revisão" value="{{ old('problema')}}"></textarea>
										</div>

										<div class="form-group">
											<label>Data:</label>
											<input class="form-control" name="data" required type="date" placeholder="DD/MM/AAAA" value="{{ old('data')}}"/>
										</div>

										<div class="form-group">
											<label>Item:</label>
											<input class="form-control" name="item" placeholder="Item comprado (Opcional)" maxlength="45" value="{{ old('item')}}"/>
										</div>

										<div class="form-group">
											<label>Nota fiscal:</label>
											<input class="form-control" name="nota_fiscal" placeholder="Nota fiscal da compra (Opcional)" maxlength="45" value="{{ old('nota_fiscal')}}"/>
										</div>

										<div class="form-group">
											<label>Valor:</label>
											<input class="form-control" name="valor" type="numeric" placeholder="Valor da compra (Opcional)" value="{{ old('valor')}}"/>
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