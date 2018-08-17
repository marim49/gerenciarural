@extends('layouts.layout') @section('content')
<script src="{{ asset('js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('js/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/dataTables/sum.js') }}"></script>
<script>
</script>
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Relatório de Revisão</h3>
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
					Máquinas revisionadas
				</div>
				<div class="panel-body">
					<div class="table-responsive">

						<table id="drevisao" class="table table-striped table-bordered table-hover" style="width:100%">
							<thead>
								<tr>
									<th>Máquina Revisionada</th>
									<th>Funcionário Responsável</th>
									<th>Item comprado</th>
									<th>Nota Fiscal</th>
									<th>Valor (R$)</th>
									<th>Problema</th>
									<th>Data</th>
									<th>Cancelar operação</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($revisoes as $revisao) @if($revisao->cancelado == 0)
								<tr>
									<td>{{$revisao->maquina->nome}}</td>
									<td>{{$revisao->funcionario->nome}}</td>
									<td>{{$revisao->item}}</td>
									<td>{{$revisao->nota_fiscal}}</td>
									@if($revisao->valor)
									<td>{{$revisao->valor}}</td>
									@else
									<td>0</td>
									@endif
									<td>{{$revisao->problema}}</td>
									<td>{{$revisao->data}}</td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal_cancelar" onclick="cancelarOperacao()"
											    data-route="revisao" data-id="{{$revisao->id}}">Cancelar</button>
										</center>
									</td>
								</tr>
								@endif @endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Total:</th>
									<th colspan="7" style="text-align:center"></th>
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
											<input hidden name="cancelado" value="1"/>
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