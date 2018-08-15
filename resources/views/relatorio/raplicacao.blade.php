@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Relatório Histórico Animal</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Relatório Aplicação animal
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						
						<table class="table table-striped table-bordered table-hover" id="aplicacao">
							<thead>
								<tr>
									<th>Funcionário</th>
									<th>Animal</th>
									<th>Medicamento </th>
									<th>Quantidade Aplicada</th>
									<th>Motivo</th>
									<th>Data da aplicação</th>


								</tr>
							</thead>
							<tbody>
								@foreach ($historicos_animais as $historico)
								<tr>
									<td> {{$historico->funcionario->nome}} </td>
									<td> {{$historico->animal->nome}} </td>
									<td> {{$historico->medicamento->nome}} </td>
									<td> {{$historico->quantidade}} </td>
									<td> {{$historico->motivo}} </td>
									<td> {{$historico->data}} </td>

								</tr>
								@endforeach
								<tfoot>
            <tr>
                <th>Total:</th>
                <th colspan="4" style="text-align:center"></th>
            </tr>
        </tfoot>

							</tbody>

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