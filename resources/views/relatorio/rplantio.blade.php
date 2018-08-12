@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Relatório plantio</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Relatório de plantio
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						
						<table class="table table-striped table-bordered table-hover" id="plantio">
							<thead>
								<tr>
									<th>Terra pertencente</th>
									<th>insumo Aplicado</th>
									<th>Funcionário que aplicou </th>
									<th>Quantidade</th>
									<th>Data da aplicação</th>


								</tr>
							</thead>
							<tbody>
								@foreach ($historicos_terra as $historico)
								<tr class='gradeA'>
									<td> {{$historico->terra->nome}} </td>
									<td> {{$historico->insumo->TipoInsumo->nome}} </td>
									<td> {{$historico->funcionario->nome}} </td>
									<td> {{$historico->quantidade}} </td>
									<td> {{$historico->data}} </td>

								</tr>
								@endforeach

							</tbody>
							<tfoot>
            <tr>
                <th>Total:</th>
                <th colspan="4" style="text-align:center"></th>
            </tr>
        </tfoot>

						</table>
						<a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a>
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