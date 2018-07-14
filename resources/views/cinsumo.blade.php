 @extends('layouts.layout')
 @section('content')

<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Insumos</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Cadastre o insumo inserindo-o nos campos abaixo
				</div>
				<form name="register-insumos" action="../../controller/cadastro/insumos/insumos.php" method="post">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Selecione o celeiro</label>
											<select class="form-control" name="tipomed">
												<option value="">Celeiro 1</option>
												<option value="">Two Vale</option>
												<option value="{{}}">Three Vale</option>
												<option value="">Four Vale</option>
											</select>
										</div>

									</div>
									<div class="col-md-4">

									</div>
								</div>

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Tipo de insumo</label>
											<select class="form-control" name="tipomed">
												<option value="">Milho</option>
												<option value="">Two Vale</option>
												<option value="">Three Vale</option>
												<option value="">Four Vale</option>
											</select>
										</div>

									</div>
									<div class="col-md-4">

									</div>
								</div>
								
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label>Quantidade:</label>
											<input class="form-control" name="quantidade" type="number" placeholder="" />
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

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@endsection