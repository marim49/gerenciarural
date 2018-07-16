 @extends('layouts.layout') @section('content')
<script>
	function modalEditar() {
		$("#abremodalFuncionario").click(function () {
			var request = $.ajax({
				url: "funcionario/2/edit",
				async: true
			});

			request.done(function (data) {
				$("#conteudoModal").html(data);
			});

			request.fail(function () {
				console.log("Ocorreu um erro na requisição");
			});
		});
	}

	function modalRelatorio() {
		$("#abrerelatorioFuncionario").click(function () {
			var request = $.ajax({
				url: "funcionario/1/edit"

			});

			request.done(function (data) {
				$("#conteudoModal").html(data);
			});

			request.fail(function () {
				console.log("Ocorreu um erro na requisição");
			});
		});
	}
</script>

<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Funcionário</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Buscar por Funcionários
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Cargo</th>
									<th>celular</th>
									<th>Data de admissão</th>
									<th> Relatório </th>
									<th> Editar </th>
									<th> Excluir </th>
								</tr>
							</thead>
							<tbody>
								@foreach ($funcionarios as $funcionario)
								<tr class='gradeA'>
									<a>
										<td> {{$funcionario->nome}} </td>
									</a>
									<td> {{$funcionario->cargo}} </td>
									<td> {{$funcionario->celular}} </td>
									<td> {{$funcionario->admissao}} </td>

									<td>
										<center>
											<a id="abrerelatorioFuncionario" href='#modal_theme_danger' onclick="modalRelatorio()" data-toggle='modal' data-target='#modal_form_vertical'>
												<span class='icon-book alert-info'></span>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a id="abremodalFuncionario" href='#modal_theme_danger' onclick="modalEditar()" data-toggle='modal' data-target='#modal_form_vertical'>
												<span class='icon-pencil7 alert-warning'></span>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href='../../db/funcionarios/deletar.php?id=$escrever[id_func]'>
												<span class='icon-trash alert-danger'></span>
											</a>
										</center>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
					<a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a>

				</div>



			</div>

			<div class="modal fade" id="modal_form_vertical">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
							<h5 class='modal-title'>Editar Funcionário </h5>
						</div>
						<div id="printjs" class="modal-body">
							<div id="conteudoModal">

							</div>
						</div>
					</div>
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