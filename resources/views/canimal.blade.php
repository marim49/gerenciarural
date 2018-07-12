 @extends('layouts.layout') @section('content')

<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Animais</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Cadastre o animal inserindo-o nos campos abaixo
				</div>
				<form name="register-animal" action="../../controller/cadastro/animais/animais.php" method="post">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">

								<div class="form-group">
									<label>Identificão do Animal:</label>
									<input class="form-control" name="nome_animal" type="text" placeholder="" />
								</div>
								
								<div class="form-group">
									<label>Grupo Animal</label>
									<select class="form-control" name="tipomed">
										<option value="">Grupo A</option>
										<option value="">Two Vale</option>
										<option value="">Three Vale</option>
										<option value="">Four Vale</option>
									</select>
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