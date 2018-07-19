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
			@endif
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
								@foreach ($fazendas as $fazenda)
								<tr class='gradeA'>
									<td> {{$fazenda->nome}} </td>
									@if($fazenda->localidade)
									<td> {{$fazenda->localidade}} </td>
									@else
									<td> - </td>
									@endif
									<td>
										<a href='#modal_theme_danger' data-toggle='modal' data-target='#modal_form_update{{$fazenda->id}}'>
											<span class='icon-pencil7'></span>
										</a>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
					<a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a>
				</div>



			</div>
			<!-- Modal de Editar Dados -->
			@foreach ($fazendas as $fazenda)
			<div id='modal_form_update{{$fazenda->id}}' class='modal fade'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
							<h5 class='modal-title'>Editar Fazenda </h5>
						</div>

						<form name='update-fazenda' action="{{ route('fazenda.update', $fazenda->id) }}" method='POST'>
							{{ csrf_field() }} {{ method_field('PUT') }}
							<div class='panel-body'>
								<div class='row'>
									<div class='col-md-4'>

										<div class='form-group'>
											<label>Nome:</label>
											<input class='form-control' name='nome' type='text' value='{{$fazenda->nome}}' />
										</div>
										<div class='form-group'>
											<label>Localidade:</label>
											<input class='form-control' name='localidade' type='text' value='{{$fazenda->localidade}}' />
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
			@endforeach
		</div>

	</div>
</div>
<!--End Advanced Tables -->
</div>
</div>
</div>

@endsection