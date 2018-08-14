@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Revisões</h3>
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
					Buscar por Revisões
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Fazenda</th>
									<th>Máquina</th>
									<th>Funcionário</th>
									<th>Item (Comprado)</th>
									<th>Nota Fiscal</th>
									<th>Valor</th>
									<th>Problema</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
							@if(isset($revisoes))
								@foreach ($revisoes as $revisao)
								<tr class='gradeA'>
									<td> {{$revisao->Fazenda->nome}} </td>
									<td> {{$revisao->Maquina->nome}} </td>
									<td> {{$revisao->Funcionario->nome}} </td>
									<td> {{$revisao->item}} </td>
									<td> {{$revisao->nota_fiscal}} </td>
									<td> {{$revisao->valor}} </td>
									<td> {{$revisao->problema}} </td>
									<td>  </td>
								</tr>
								@endforeach
							@endif
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