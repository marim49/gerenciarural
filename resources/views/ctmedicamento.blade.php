

@extends('layouts.layout')

@section('content')
<div class="container">
		<!--Cabeçalho pagina-->
		<div class="col-md-12">
			<div class="row pad-botm">
				<h3 class="header-line">Tipo de medicamento</h3>
			</div>
		</div>
		<!--/Cabeçalho pagina-->

		<!--Conteudo da pagina-->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Tipo de medicamento
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<form role="form">
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label>Tipo de medicamento:</label>
												<input class="form-control" type="text" name="tipomed" placeholder="" />
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