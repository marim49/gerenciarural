 @extends('layouts.layout') @section('content')
<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Saída de Medicamento</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> A medicação foi registrada no histórico.
			</div>
			@endif 
			@if ($errors->any())
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
					Informações do animal medicado
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="medicacao" action="{{ route('medicacao.store') }}" method="post">
							{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select type="hidden" id="fazendas" required class="form-control" onchange="SaidaMedicamento()">
												<option value="" disabled selected>- Selecione uma fazenda -</option>												
												@foreach($fazendas as $fazenda)
												<option value="{{$fazenda}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>										

										<div class="form-group">
											<label>Funcionário responsável:</label>
											<select id="funcionario" required class="form-control" name="id_funcionario">
												<option value="" disabled selected>- Selecione uma fazenda -</option>												
											</select>
										</div>

										<div class="form-group">
											<label>Animal medicado:</label>
											<select id="animal" required class="form-control" name="id_animal">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Motivo:</label>
											<input class="form-control" type="text" name="motivo" placeholder="Motivo da aplicacação (Opcional)" maxlenght="1" value="{{ old('motivo')}}" maxlength="100"/>
										</div>

										<div class="form-group">
											<label>Medicamento usado:</label>
											<select id="medicamento" required class="form-control" name="id_medicamento">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Quantidade ( ML ):</label>
											<input class="form-control" type="number" step=".01" required name="quantidade" placeholder="Quantidade aplicada em Ml" value="{{ old('quantidade')}}"/>
										</div>

										<div class="form-group">
											<label>Data de aplicação:</label>
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