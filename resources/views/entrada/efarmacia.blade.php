 @extends('layouts.layout') @section('content')
<script>
	function AddRow() {
		var tbl = document.getElementById('myTable').getElementsByTagName('tbody')[0];
		var tr = tbl.insertRow();

		fazenda = JSON.parse($("#fazendas").val());
		medicamentos = fazenda.medicamentos;

		//Célula de medicameto
		var td = tr.insertCell();
		var mdt = document.createElement("select");
		mdt.required = true;
		mdt.name = "id_medicamento[]";
		if (!$.isEmptyObject(medicamentos)) {
			for (var i in medicamentos) {
				var el = document.createElement("option");
				el.textContent = medicamentos[i].nome + " | Tipo do Medicamento: " + medicamentos[i].tipo_medicamento.nome;
				el.value = medicamentos[i].id;
				mdt.appendChild(el);
			}
		} else {
			var el = document.createElement("option");
			el.textContent = 'Vazio';
			el.value = '';
			mdt.appendChild(el);
		}
		td.appendChild(mdt);

		//Célula de quantidade
		var td = tr.insertCell();
		var qtd = document.createElement("input");
		qtd.type = "number";
		qtd.step = "0.01";
		qtd.required = true;
		qtd.onchange = function () {
			var row = document.getElementById("myTable").rows[tr.rowIndex];
			var quantidade = row.cells[1].children[0].value;
			var ml = row.cells[2].children[0].value;
			if (ml == "")
				if (quantidade == "")
					row.cells[3].children[0].value = "";
				else
					row.cells[3].children[0].value = quantidade;
			else
				row.cells[3].children[0].value = quantidade * ml;
		}
		td.appendChild(qtd);

		//Célula de ml
		var td = tr.insertCell();
		var ml = document.createElement("input");
		ml.type = "number";
		ml.onchange = function () {
			var row = document.getElementById("myTable").rows[tr.rowIndex];
			var quantidade = row.cells[1].children[0].value;
			var ml = row.cells[2].children[0].value;
			if (quantidade == "")
				row.cells[3].children[0].value = "";
			else
			if (ml == "")
				row.cells[3].children[0].value = quantidade;
			else
				row.cells[3].children[0].value = quantidade * ml;
		}
		td.appendChild(ml);

		//Célula de cálculo
		var td = tr.insertCell();
		var total = document.createElement("input");
		total.name = 'quantidade[]';
		total.readOnly = true;
		td.appendChild(total);

		//Botão de excluir 
		var td = tr.insertCell();
		var span = document.createElement('span');
		span.classList.add('table-remove', 'glyphicon', 'glyphicon-remove');
		span.onclick = function deleteRow() {
			document.getElementById("myTable").deleteRow(tr.rowIndex);
		}
		td.appendChild(span);
	}
</script>
<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Entrada de Medicamentos</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> A entrada de medicamento foi registrada no histórico.
			</div>
			@endif @if ($errors->any())
			<div class="alert alert-warning alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Ops!</strong> {{$errors->first()}}.
			</div>
			@endif
		</div>
	</div>
	<!--/Cabeçalho pagina-->

	<!--Conteudo da pagina-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Dados da compra
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="armazenar" action="{{ route('compra-medicamento.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select type="hidden" id="fazendas" required class="form-control" onchange="EntradaMedicamento()">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
												@foreach($fazendas as $fazenda)
												<option value="{{$fazenda}}">{{$fazenda->nome}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group" style="display: none;" id="div_funcionario">
											<label>Funcionário:</label>
											<select id="funcionario" required class="form-control" name="id_funcionario">
												<option value="" disabled selected>- Selecione uma fazenda -</option>
											</select>
										</div>

										<div class="form-group">
											<label>Fornecedor:</label>
											<select type="hidden" name="id_fornecedor" required class="form-control" onchange="EntradaMedicamento()">
												@foreach($fornecedores as $fornecedor) @if(old('id_fornecedor') == $fornecedor->id)
												<option value="{{$fornecedor->id}}" selected>{{$fornecedor->nome}}</option>
												@else
												<option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
												@endif @endforeach
											</select>
										</div>

										<div class="form-group">
											<label>Data da Compra:</label>
											<input class="form-control" name="data" required type="date" placeholder="DD/MM/AAAA" value="{{ old('data')}}" />
										</div>

										<div class="form-group">
											<label>Nota Fiscal:</label>
											<input class="form-control" type="text" required name="nota_fiscal" placeholder="Número da nota fiscal da compra" value="{{ old('nota_fiscal')}}"
											/>
										</div>

										<div class="form-group">
											<label>Lote:</label>
											<input class="form-control" type="text" name="lote" placeholder="Número do lote" value="{{ old('lote')}}" />
										</div>

										<div class="form-group">
											<label>Valor:</label>
											<input class="form-control" type="text" name="valor" required placeholder="Em R$" value="{{ old('valor')}}" />
										</div>

										<div style="display: none;" class="form-group table-responsive" id="produtos">
											<label>Produtos da nota:</label>

											<table class="tableprod table-striped table-bordered table-hover" id="myTable">
												<thead>
													<tr>
														<th>Medicamento</th>
														<th>Qtd</th>
														<th>Ml (opcional)</th>
														<th>Total</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>

											<span class="table-add glyphicon glyphicon-plus" onclick="AddRow()"></span>

										</div>
									</div>
								</div>

								<div class="right-div">
									<button type="submit" class="btn btn-info pull-right">Salvar </button>
								</div>
								<div class="right-div">
									<button type="reset" class="btn btn-info pull-right">Limpar </button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection