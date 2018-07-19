@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Terras</h3>
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
					Buscar por Terras
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Tamanho da área</th>
									<th>Fazenda</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($terras as $terra)
								<tr class='gradeA'>
									<td> {{$terra->nome}} </td>
									@if($terra->area)
									<td> {{$terra->area}} </td>
									@else
									<td>
										<center>-</center>
									</td>
									@endif
									<td> {{$terra->Fazenda->nome}} </td>
									<td>
										<a>
											<center>
												<span class='icon-pencil7 alert-warning'></span>
											</center>
										</a>
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