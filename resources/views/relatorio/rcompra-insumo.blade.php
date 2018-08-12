@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Relatório Compra Insumo</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Relatório de Compra de Insumo
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						
						<table class="table table-striped table-bordered table-hover" id="insumo">
							<thead>
								<tr>
									<th>Funcionário</th>
									<th>Insumo</th>
									<th>Quantidade </th>
									<th>Data</th>
									<th>Valor</th>
									<th>Nota Fiscal</th>
									<th>Lote</th>


								</tr>
							</thead>
							<tbody>
								@foreach ($historicos_compra_insumo as $historico)
								<tr class='gradeA'>
									<td> {{$historico->funcionario->nome}} </td>
									<td> {{$historico->insumo->TipoInsumo->nome}} </td>
									<td> {{$historico->quantidade}} </td>
									<td> {{$historico->data}} </td>
									<td> {{$historico->valor}} </td>
									<td> {{$historico->nota_fiscal}} </td>
									<td> {{$historico->lote}} </td>

								</tr>
								@endforeach

							</tbody>
							<tfoot>
            <tr>
                <th>Total Quant:</th>
				<th colspan="2" style="text-align:center"></th>
				<th>Total Val:</th>
				<th colspan="3" style="text-align:center"></th>
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