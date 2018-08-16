@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Relatório Compra Combustível</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Relatório Compra de Combustivel
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						
						<table class="table table-striped table-bordered table-hover" id="dcombustivel">
							<thead>
								<tr>
									<th>Funcionário</th>
									<th>Quantidade </th>									
									<th>Data da Compra</th>
									<th>Valor</th>
									<th>Nota Fiscal</th>
									<th>Lote</th>
									<th>Cancelar operação</th>


								</tr>
							</thead>
							<tbody>
								@foreach ($historicos_compra_combustivel as $historico)
								<tr class='gradeA'>
									<td> {{$historico->funcionario->nome}} </td>
									<td> {{$historico->quantidade}} </td>									
									<td> {{$historico->data}} </td>
									<td> {{$historico->valor}} </td>
									<td> {{$historico->nota_fiscal}} </td>
									<td> {{$historico->lote}} </td>
									<td>
					<center>
						<button type="button" class="btn btn-xs btn-danger" onclick="" data-toggle="modal"
						data-target="#modal_theme_danger">Cancelar</button>
					</center>
				</td>

								</tr>
								@endforeach

							</tbody>
							<tfoot>
            <tr>
                <th>Total Quant:</th>
				<th></th>
				<th>Total Val:</th>
				<th colspan="4" style="text-align:center"></th>
            </tr>
        </tfoot>

						</table>
						<!-- Modal de delete -->
						<div id="modal_theme_danger" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">AVISO!</h6>
              </div>

              <div class="modal-body">
                <h6 class="text-semibold">Tem certeza que deseja cancelar esta operação?</h6>

              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-danger">Sim</button>

              </div>
            </div>
          </div>
        </div>
        <!-- Modal de delete -->
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