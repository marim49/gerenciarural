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
			<h3 class="header-line">Relatório Abastecimento</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Relatório de abastecimento de Máquina
				</div>
				<div class="panel-body">
					<div class="table-responsive">
					<table id="dabastecimento" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
				<th>Máquina abastecida</th>
				<th>Funcionário que abasteceu</th>
				<th>Quantidade</th>
				<th>Data do abastecimento</th>
				<th>Cancelar operação</th>
            </tr>
        </thead>
        <tbody>
		@foreach ($historicos_abastecimento as $historico)
            <tr>
                <td>{{$historico->maquina->nome}}</td>
                <td>{{$historico->funcionario->nome}}</td>
                <td>{{$historico->quantidade}}</td>
                <td>{{$historico->data}}</td>
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
                <th>Total:</th>
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

<!-- 	
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									
									<th>Máquina abastecida</th>
									<th>Funcionário que abasteceu</th>
									<th>Quantidade</th>
									<th>Horímetro</th>
									<th>Data do abastecimento</th>


								</tr>
							</thead>
							<tfoot>
        <tr>
            <th colspan="3" style="text-align:right">Total</th>
            <th></th>
        </tr>
    </tfoot>
							<tbody>
								@foreach ($historicos_abastecimento as $historico)
								<tr class='gradeA'>
									
									<td> {{$historico->maquina->nome}} </td>
									<td> {{$historico->funcionario->nome}} </td>
									<td> {{$historico->quantidade}} </td>
									<td> {{$historico->horimetro}} </td>
									<td> {{$historico->data}} </td>

								</tr>
								@endforeach

							</tbody>

						</table>

						-->