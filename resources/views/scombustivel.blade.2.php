 @extends('layouts.layout') @section('content')
<div class="container">
	<!--Cabeçalho pagina-->
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Retirada de combustível</h3>
		</div>
	</div>
	<!--/Cabeçalho pagina-->

	<!--Conteudo da pagina-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Retirar
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<form role="form">
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Quantidade a retirar:</label>
											<input class="form-control" type="text" placeholder="Em litros" />
										</div>
										<div class="form-group">
											<label>Data de Saida:</label>
											<input class="form-control" name="data_abast" type="date" placeholder="DD/MM/AAAA" />
										</div>
										<div class="form-group">
                                            <label>Máquina de Destino</label>
                                            <select class="form-control" name="maquina_dest">
                                                <option value="">Relampago marquinhos</option>
                                                <option value ="">Two Vale</option>
                                                <option value="">Three Vale</option>
                                                <option value="">Four Vale</option>
                                            </select>
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