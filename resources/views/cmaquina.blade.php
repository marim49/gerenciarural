@extends('layouts.layout')
@section('content')

<div class="container">
		<div class="col-md-12">
			<div class="row pad-botm">
				<h3 class="header-line">Cadastrar Máquinas</h3>
				@if (isset($success))
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
                                            <label>Fazenda:</label>
                                            <select class="form-control" name="id_fazenda">
												@foreach($fazendas as $fazenda)
													<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
												@endforeach
                                            </select>
                                        </div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label>Nome do máquina:</label>
												<input class="form-control" name="nome" type="text" placeholder="" />
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Data de Compra:</label>
												<input class="form-control" name="data_aquisicao" type="date" placeholder="DD/MM/AAAA" />
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