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
					<table id="abastecimento" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
				<th>Máquina abastecida</th>
				<th>Funcionário que abasteceu</th>
				<th>Quantidade</th>
				<th>Data do abastecimento</th>
            </tr>
        </thead>
        <tbody>
		@foreach ($historicos_abastecimento as $historico)
            <tr>
                <td>{{$historico->maquina->nome}}</td>
                <td>{{$historico->funcionario->nome}}</td>
                <td>{{$historico->quantidade}}</td>
                <td>{{$historico->data}}</td>
			</tr>
		@endforeach
            
	
        </tbody>
        <tfoot>
            <tr>
                <th>Total:</th>
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