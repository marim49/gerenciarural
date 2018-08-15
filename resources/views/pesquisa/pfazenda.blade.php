@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Fazenda</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Atualizado!</strong> A fazenda foi atualizada.
			</div>
			@endif @if ($errors->any())
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
					Buscar por Fazendas
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Localidade</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($fazendas))
								@foreach ($fazendas as $fazenda)
								<tr class='gradeA'>
									<td> {{$fazenda->nome}} </td>
									@if($fazenda->localidade)
									<td> {{$fazenda->localidade}} </td>
									@else
									<td>
										<center>-</center>
									</td>
									@endif
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-warning" onclick="editarFazenda()" data-toggle="modal" data-target="#exampleModal"
											    data-nome="{{$fazenda->nome}}" data-id="{{$fazenda->id}}" data-localidade="{{$fazenda->localidade}}">Editar</button>
										</center>
									</td>
								</tr>
								@endforeach
								@endif

							</tbody>
						</table>
					</div>
				</div>



			</div>
			
			<!-- Modal de Editar Dados -->
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
						
							@if(isset($fazenda))
							<form name='update-fazenda' action="{{ route('fazenda.update', $fazenda->id) }}" method='POST'>
								{{ csrf_field() }} {{ method_field('PUT') }}
								<div class='panel-body'>
									<div class='row'>
										<div class='col-md-4'>

											<div class="form-group">
												<label>Nome:</label>
												<input class="form-control" id="nome" name="nome" type="text" value="{{$fazenda->nome}}" />
											</div>
											<div class="form-group">
												<label>Localidade:</label>
												<input class="form-control" id="localidade" name="localidade" type="text" value="{{$fazenda->localidade}}" />
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
<!--End Advanced Tables -->
</div>
</div>
</div>

@endsection