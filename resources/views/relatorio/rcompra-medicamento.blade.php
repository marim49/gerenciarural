@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Relatório de Compras</h3>
		</div>
	</div>
	@if ($errors->any())
	<div class="alert alert-warning alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Ops!</strong> {{$errors->first()}}.
	</div>
	@endif @if (session()->has('success'))
	<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Cancelado!</strong> A operação do histórico foi cancelada.
	</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Relatório de compra de Medicamentos
				</div>
				<div class="panel-body">
					<div class="table-responsive">

						<table class="table table-striped table-bordered table-hover" id="dmedicamento">
							<thead>
								<tr>
									<th>Funcionário</th>
									<th>Medicamento</th>
									<th>Quantidade </th>
									<th>Data</th>
									<th>Valor</th>
									<th>Nota Fiscal</th>
									<th>Lote</th>
									<th>Cancelar operação</th>

								</tr>
							</thead>
							<tbody>
								@foreach ($historicos_compra_medicamento as $historico) @if($historico->cancelado == 0)
								<tr class='gradeA'>
									<td> {{$historico->funcionario->nome}} </td>
									<td> {{$historico->medicamento->TipoMedicamento->nome}} | {{$historico->medicamento->nome}} </td>
									<td> {{$historico->quantidade}} </td>
									<td> {{$historico->data}} </td>
									<td> {{$historico->valor}} </td>
									<td> {{$historico->nota_fiscal}} </td>
									<td> {{$historico->lote}} </td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-danger" onclick="cancelarOperacao()" data-route="compra-medicamento" data-id="{{$historico->id}}"
											  data-toggle="modal" data-target="#modal_cancelar">Cancelar</button>
										</center>
									</td>
								</tr>
								@endif @endforeach

							</tbody>
							<tfoot>
								<tr>
									<th>Total Quant:</th>
									<th colspan="2" style="text-align:center"></th>
									<th>Total Val:</th>
									<th colspan="4" style="text-align:center"></th>
								</tr>
							</tfoot>
						</table>

						<!-- Modal de cancelar -->
						<div id="modal_cancelar" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h6 class="modal-title">AVISO!</h6>
									</div>

									<form id="cancelar" method="POST">
										{{ csrf_field() }} {{ method_field('DELETE') }}
										<div class="modal-body form-group">
											<h6 class="text-semibold">Tem certeza que deseja cancelar esta operação?</h6>
											<input hidden name="cancelado" value="1" />
											<input name="motivo" size="70%" placeholder="Descreva em 100 caracteres o motivo do cancelamento" required maxleght=100/>
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-link" data-dismiss="modal">Não</button>
											<button type="submit" class="btn btn-danger">Sim</button>
										</div>
									</form>

								</div>
							</div>
						</div>
						<!-- Modal de cancelar -->

						<!-- <a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a> -->

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>

@endsection