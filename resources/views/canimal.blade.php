

@extends('layouts.layout')

@section('content')

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
								<div class="col-md-4">

									<div class="form-group">
										<label>Identificão do Animal:</label>
										<input class="form-control" name="nome_animal" type="text" placeholder="" />
									</div>
									<div class="form-group">
										<label>Número de registro:</label>
										<input class="form-control" name="numero_registro" type="text" placeholder="" />
									</div>
									<div class="form-group">
										<label>Peso:</label>
										<input class="form-control" name="peso" type="text" placeholder="Em arrobas" />
									</div>
									<div class="form-group">
										<label>Tratamento realizado:</label>
										<input class="form-control" name="tratamento_feito" type="text" placeholder="" />
									</div>
									<div class="form-group">
										<label>Histórico:</label>
										<input class="form-control" name="historico" type="text" placeholder="" />
									</div>


								</div>
								<div class="col-md-4">

									<div class="form-group">
										<label>Pai:</label>
										<input class="form-control" name="pai_animal" type="text" placeholder="" />

									</div>
									<div class="form-group">
										<label>Data de Nascimento:</label>
										<input class="form-control" name="data_nasc_animal" type="date" placeholder="DD/MM/AAAA" />
									</div>
									<div class="form-group">
										<label>Medicamentos Utilizados:</label>
										<input class="form-control" name="medicamento_usados" type="text" placeholder="" />
									</div>


								</div>
								<div class="col-md-4">

									<div class="form-group">
										<label>Mãe:</label>
										<input class="form-control" name="mae_animal" type="text" placeholder="" />
									</div>
									<div class="form-group">
										<label>Data de Chegada:</label>
										<input class="form-control" name="data_chegada" type="date" placeholder="DD/MM/AAAA" />
									</div>
									<div class="form-group">
										<label></label>
										<input class="form-control" type="hidden" />
									</div>

									<div class="form-group">
										<label></label>
										<input class="form-control" type="hidden" />
									</div>

									<div class="form-group">
										<label>Foto do animal:</label>
										<div class="form-group">
											<input type="file" />
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