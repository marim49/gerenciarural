<div class="table-responsive">
<a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a>
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Cargo</th>
				<th>RG</th>
				<th>CPF</th>
				<th>PIS</th>
				<th>celular</th>
				<th>Data de admissão</th>
				<th>CEP</th>
				<th>Endereço</th>
				<th>Bairro</th>
				<th>Cidade</th>
				<th>Estado</th>
				
			</tr>
		</thead>
		<tbody>
			@foreach ($funcionarios as $funcionario)
			<tr class='gradeA'>
					<td> {{$funcionario->nome}} </td>
				<td> {{$funcionario->cargo}} </td>
				<td> {{$funcionario->rg}} </td>
				<td> {{$funcionario->cpf}} </td>
				<td> {{$funcionario->pis}} </td>
				<td> {{$funcionario->celular}} </td>
				<td> {{$funcionario->admissao}} </td>
				<td> {{$funcionario->cep}} </td>
				<td> {{$funcionario->endereco_rua}} {{$funcionario->endereco_numero}}  </td>
				<td> {{$funcionario->endereco_bairro}} </td>
				<td> {{$funcionario->endereco_cidade}} </td>
				<td> {{$funcionario->endereco_estado}} </td>

			</tr>
			@endforeach

		</tbody>
		
	</table>
	
</div>