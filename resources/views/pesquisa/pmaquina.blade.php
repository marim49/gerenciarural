@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Máquina</h3>
			@if ($errors->any())
			<div class="alert alert-warning alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Ops!</strong> {{$errors->first()}}.
			</div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Buscar por máquinas
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Fazenda</th>
									<th>Nome</th>
									<th>Data de compra</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($maquinas as $maquina)
								<tr class='gradeA'>
									<td> {{$maquina->Fazenda->nome}} </td>
									<td> {{$maquina->nome}} </td>
									<td> {{$maquina->data_aquisicao}} </td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-warning" onclick="editarMaquina()" data-toggle="modal" data-target="#exampleModal"
											    data-nome="{{$maquina->nome}}" data-id="{{$maquina->id}}" data-fazenda="{{$maquina->id_fazenda}}"
												data-datacompra="{{$maquina->data_aquisicao}}">Editar</button>
										</center>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title" id="exampleModalLabel">Curso</h4>
								</div>
								<div class="modal-body">
									<form name='update-maquina' action="{{ route('maquina.update', $maquina->id) }}" method='POST'>
										{{ csrf_field() }} {{ method_field('PUT') }}
										<div class="panel-body">
											<div class="row">
												<div class="col-md-8">
													<div class="form-group">
														<label>Fazenda: *</label>
														<select class="form-control" id="fazenda" name="id_fazenda">
															@foreach($fazendas as $fazenda) @if (old('id_fazenda') == $fazenda->id)
															<option value="{{$fazenda->id}}" selected>{{$fazenda->nome}}</option>
															@else
															<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
															@endif @endforeach
														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-5">
													<div class="form-group">
														<label>Nome: *</label>
														<input class="form-control" id="nome" name="nome" type="text" placeholder="Nome da máquina" maxlength="45" value="{{ old('nome')}}"
														/>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-5">
													<div class="form-group">
														<label>Data de Compra: *</label>
														<input class="form-control" id="datacompra" name="data_aquisicao" type="date" placeholder="DD/MM/AAAA" value="{{ old('data_aquisicao')}}"
														/>
													</div>
												</div>
											</div>

										</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
											<button type='submit' class='btn btn-primary'>Editar</button>
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
</div>
<!--End Advanced Tables -->
</div>
</div>
</div>

@endsection