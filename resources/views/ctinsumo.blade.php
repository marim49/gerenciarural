 @extends('layouts.layout') @section('content')
<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Tipo Insumo</h3>
		</div>
	</div>
	<!--/Cabeçalho pagina-->

	<!--Conteudo da pagina-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Cadastrar Tipo Insumo
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<form role="form">
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Nome do insumo:</label>
											<input class="form-control" type="text" name="insumo" placeholder="" />
										</div>
									</div>
									<div class="col-md-4">

									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label>Número da nota fiscal:</label>
											<input class="form-control" name="nf_insumo" type="number" placeholder="" />
										</div>
									</div>
									<div class="col-md-4">

									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label>Data de Compra:</label>
											<input class="form-control" name="data_compra" type="date" placeholder="DD/MM/AAAA" />
										</div>
									</div>
									<div class="col-md-4">

									</div>

								</div>

								<div class="right-div">
									<button type="submit" class="btn btn-info pull-right">Salvar </button>
								</div>
								<div class="right-div">
									<button type="submit" class="btn btn-info pull-right">Limpar </button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/Conteudo da pagina-->
</div>
</div>
@endsection