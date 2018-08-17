 @extends('layouts.layout') @section('content')
<script>
	function AddRow() {
		var tbl = document.getElementById('myTable').getElementsByTagName('tbody')[0];
		var tr = tbl.insertRow();

		fazenda = JSON.parse($("#fazendas").val());
		insumos = fazenda.insumos;

		//Célula de medicameto
		var td = tr.insertCell();
		var mdt = document.createElement("select");
		mdt.required = true;
		mdt.name = "id_insumo[]";

		if (!$.isEmptyObject(insumos)) {
			for (var i in insumos) {
				var el = document.createElement("option");
				el.textContent = insumos[i].nome + " | Tipo do Medicamento: " + insumos[i].tipo_insumo.nome;
				el.value = insumos[i].id;
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
		qtd.name = "quantidade[]";
		qtd.type = "number";
		qtd.step = "0.01";
		qtd.required = true;
		td.appendChild(qtd);

		//Botão de excluir 
		var td = tr.insertCell();
		var span = document.createElement("span");
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
			<h3 class="header-line">Entrada de Insumo</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Registrado!</strong> A entrada de insumo foi registrada no histórico.
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
					Informações da compra
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">

							<form name="armazenar" action="{{ route('compra-insumo.store') }}" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-8">

										<div class="form-group">
											<label>Fazenda:</label>
											<select type="hidden" id="fazendas" required class="form-control" onchange="EntradaInsumo()">
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
											<input class="form-control" name="data" type="date" required placeholder="DD/MM/AAAA" value="{{ old('data')}}" />
										</div>

										<div class="form-group">
											<label>Nota Fiscal:</label>
											<input class="form-control" type="text" name="nota_fiscal" required placeholder="Número da nota da compra" value="{{ old('nota_fiscal')}}"
											/>
										</div>

										<div class="form-group">
											<label>Lote:</label>
											<input class="form-control" type="text" name="lote" placeholder="Número do lote (Opcional)" value="{{ old('lote')}}" />
										</div>

										<div class="form-group">
											<label>Valor:</label>
											<input class="form-control" required type="number" step=".01" name="valor" placeholder="Em R$" value="{{ old('valor')}}"
											/>
										</div>

										<div style="display: none;" class="form-group table-responsive" id="produtos">
											<label>Produtos da nota:</label>
											<table class="tableprod table-striped table-bordered table-hover" id="myTable">
												<thead>
													<tr>
														<th>Insumo</th>
														<th>Qtd</th>
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