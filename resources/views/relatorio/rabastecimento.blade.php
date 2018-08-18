@extends('layouts.layout') @section('content')
<script src="{{ asset('js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('js/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/dataTables/sum.js') }}"></script>
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Relatório de Abastecimento</h3>
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
			<div class="panel panel-default">
				<div class="panel-heading">
					Relatório de abastecimento de aáquinas
				</div>
				<div class="panel-body">
					<div class="table-responsive">

						<table id="dabastecimento" class="table table-striped table-bordered table-hover" style="width:100%">
							<thead>
								<tr>
									<th>Fazenda/Máquina abastecida</th>
									<th>Funcionário que abasteceu</th>
									<th>Quantidade</th>
									<th>Data do abastecimento</th>
									<th>Cancelar operação</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($historicos_abastecimento as $historico) @if($historico->cancelado == 0)
								<tr>
									<td>{{$historico->combustivel->fazenda->nome}} | {{$historico->maquina->nome}}</td>
									<td>{{$historico->funcionario->nome}}</td>
									<td>{{$historico->quantidade}}</td>
									<td>{{$historico->data}}</td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal_cancelar" onclick="cancelarOperacao()"
											    data-route="abastecimento" data-id="{{$historico->id}}">Cancelar</button>
										</center>
									</td>

								</tr>
								@endif @endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Total:</th>
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
											<textarea name="motivo" cols="60" placeholder="Descreva em 100 caracteres o motivo do cancelamento" required maxlength=100
											    style="resize: vertical"></textarea>
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