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
											<a href='#modal_theme_danger' data-toggle='modal' data-target=''>
												<span class='icon-pencil7 alert-warning'></span>
											</a>
										</center>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
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