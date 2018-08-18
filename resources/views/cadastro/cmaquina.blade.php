@extends('layouts.layout')
@section('content')

<div class="container">
		<div class="col-md-12">
			<div class="row pad-botm">
				<h3 class="header-line">Cadastrar Máquinas</h3>
				@if (session()->has('success'))
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Cadastrado!</strong> A máquina foi armazenada.
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

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Cadastre a máquina inserindo-a nos campos abaixo
					</div>

					<form name="register-maquinas" action="{{ route('maquina.store') }}" method="post">
					{{ csrf_field() }}
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">

									<div class="row">
										<div class="col-md-8">
										<div class="form-group">
                                            <label>Fazenda: *</label>
                                            <select class="form-control" name="id_fazenda" required>
											<option value="" disabled selected>- Selecione uma fazenda -</option>
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
									</div>

									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label>Nome: *</label>
												<input class="form-control" name="nome" required type="text" placeholder="Nome da máquina" maxlength="45" value="{{ old('nome')}}"/>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Data de Compra: *</label>
												<input class="form-control" name="data_aquisicao" required type="date" placeholder="DD/MM/AAAA" value="{{ old('data_aquisicao')}}"/>
											</div>
										</div>
									</div>

									<div class="right-div">
										<button type="submit" class="btn btn-info pull-right">Salvar </button>
									</div>
									<div class="right-div">
										<button type="reset" class="btn btn-info pull-right">Limpar </button>
									</div>

								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
@endsection