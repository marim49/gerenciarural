@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Medicamentos</h3>
			@if ($errors->any())
			<div class="alert alert-warning alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Ops!</strong> {{$errors->first()}}.
			</div>
			@endif @if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Salvo!</strong> Os dados foram salvos.
			</div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">

						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Fazenda</th>
									<th>Nome</th>
									<th>Tipo</th>
									<th>Estoque</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($medicamentos)) @foreach ($medicamentos as $medicamento)
								<tr class='gradeA'>
									<td> {{$medicamento->Fazenda->nome}} </td>
									<td> {{$medicamento->nome}} </td>
									<td> {{$medicamento->TipoMedicamento->nome}} </td>
									<td> {{$medicamento->quantidade}} </td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-warning" onclick="editarMedicamento()" data-toggle="modal" data-target="#exampleModal"
											    data-nome="{{$medicamento->nome}}" data-id="{{$medicamento->id}}" data-fazenda="{{$medicamento->id_fazenda}}"
											    data-tipo="{{$medicamento->id_tipo_medicamento}}" data-obs="{{$medicamento->obs}}" data-route="medicamento">Editar</button>
										</center>
									</td>
								</tr>
								@endforeach @endif
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
									<h4 class="modal-title">Editar</h4>
								</div>
								<div class="modal-body">
									@if(isset($medicamento))
									<form id="editar" name='update-medicamento' method='POST'>
										{{ csrf_field() }} {{ method_field('PUT') }}
										<div class="panel-body">

											<div class="row">
												<div class="col-md-8">
													<div class="form-group">
														<label>Fazenda:</label>
														<select class="form-control" required id="fazenda" name="id_fazenda">
															@foreach($fazendas as $fazenda) 
															<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-8">
													<div class="form-group">
														<label>Tipo de Medicamento:</label>
														<select class="form-control" required id="tipo" name="id_tipo_medicamento">
															@foreach($tipos as $tipo) 
															<option value="{{$tipo->id}}">{{$tipo->nome}}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div> 

											<div class="row">
												<div class="col-md-8">
													<div class="form-group">
														<label>Nome:</label>
														<input class="form-control" id="nome" required name="nome" type="text"
														placeholder="Nome da máquina" maxlength="45"/>
													</div>
												</div>
											</div>

											<div class="row"> 
												<div class="col-md-12">
													<div class="form-group">
														<label>Obs.:</label>
														<textarea class="form-control" id="obs" required style="resize: vertical" name="obs"
														maxlength="140" placeholder="Observações sobre o medicamento"></textarea>
													</div>
												</div>
											</div>

										</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
											<button type='submit' class='btn btn-primary'>Editar</button>
										</div>
									</form>
									@endif

								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>

@endsection