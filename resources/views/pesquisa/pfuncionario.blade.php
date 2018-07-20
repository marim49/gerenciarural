 @extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Funcionário</h3>
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
					Buscar por Funcionários
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Cargo</th>
									<th>Fazenda</th>
									<th>Celular</th>
									<th>Editar </th>
								</tr>
							</thead>
							<tbody>
								@foreach ($funcionarios as $funcionario)
								<tr class='gradeA'>
									<td>
										<span>
											<a href="" style="text-decoration:red;">{{$funcionario->nome}} </a>
										</span>
									</td>
									<td> {{$funcionario->cargo}} </td>
									<td> {{$funcionario->Fazenda->nome}} </td>
									<td> {{$funcionario->celular}}</td>
									<td>
										<center>
											<a>
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