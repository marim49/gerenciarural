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
						
						<table class="table table-striped table-bordered table-hover" id="daplicacao">
							<thead>
								<tr>
									<th>Funcionário</th>
									<th>Animal</th>
									<th>Medicamento </th>
									<th>Quantidade Aplicada</th>
									<th>Motivo</th>
									<th>Data da aplicação</th>
									<th>Cancelar operação</th>


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
									<td>
					<center>
						<button type="button" class="btn btn-xs btn-danger" onclick="" data-toggle="modal"
						data-target="#modal_theme_danger">Cancelar</button>
					</center>
				</td>

								</tr>
								@endforeach
								<tfoot>
            <tr>
                <th>Total:</th>
                <th colspan="6" style="text-align:center"></th>
            </tr>
        </tfoot>

							</tbody>

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