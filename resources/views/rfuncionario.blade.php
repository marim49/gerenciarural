<div class="table-responsive">
<a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a>
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Cargo</th>
				<th>celular</th>
				<th>Data de admissão</th>
				
			</tr>
		</thead>
		<tbody>
			@foreach ($funcionarios as $funcionario)
			<tr class='gradeA'>
					<td> {{$funcionario->nome}} </td>
				<td> {{$funcionario->cargo}} </td>
				<td> {{$funcionario->celular}} </td>
				<td> {{$funcionario->admissao}} </td>
			</tr>
			@endforeach

		</tbody>
		
	</table>
	
</div>