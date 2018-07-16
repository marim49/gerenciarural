

@extends('layouts.layout')

@section('content')
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
											<th> </th>
											<th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach ($medicamentos as $medicamento)
                                        <tr class='gradeA'>
													<td> {{$medicamento->nome}} </td>
													<td> {{$medicamento->cargo}} </td>
													<td> {{$medicamento->celular}} </td>
													<td> {{$medicamento->admissao}} </td>
													
													<td><a href='#modal_theme_danger' data-toggle='modal' data-target='#modal_form_vertical$escrever[id_func]'><span class='icon-pencil7'></span> </a>
													</td>
													<td><a href='../../db/medicamentos/deletar.php?id=$escrever[id_func]'><span class='icon-trash'></span> </a> </td>
													</tr>
													@endforeach	
											
                                    </tbody>
                                </table>
								</div>
								<a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a>
						</div>
								
							
							
						</div>
						@foreach ($medicamentos as $medicamento)
							<div id='modal_form_vertical{{$medicamento->id_animal}}' class='modal fade'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal'>&times;</button>
											<h5 class='modal-title'>Editar Funcionário </h5>
										</div>
										<form name='register-animal' action='../../controller/editar/animais/animais.php?id=$escrever[id_animal]' method='post'>
											<div class='panel-body'>
												<div class='row'>
													<div class='col-md-4'>

														<div class='form-group'>
															<label>Identificão do Animal:</label>
															<input class='form-control' name='nome_animal' type='text' placeholder='' />
														</div>
														<div class='form-group'>
															<label>Número de registro:</label>
															<input class='form-control' name='numero_registro' type='text' placeholder='' />
														</div>
														<div class='form-group'>
															<label>Peso:</label>
															<input class='form-control' name='peso' type='text' placeholder='Em arrobas' />
														</div>
														<div class='form-group'>
															<label>Tratamento realizado:</label>
															<input class='form-control' name='tratamento_feito' type='text' placeholder='' />
														</div>
														<div class='form-group'>
															<label>Histórico:</label>
															<input class='form-control' name='historico' type='text' placeholder='' />
														</div>


													</div>
													<div class='col-md-4'>

														<div class='form-group'>
															<label>Pai:</label>
															<input class='form-control' name='pai_animal' type='text' placeholder='' />

														</div>
														<div class='form-group'>
															<label>Data de Nascimento:</label>
															<input class='form-control' name='data_nasc_animal' type='date' placeholder='DD/MM/AAAA' />
														</div>
														<div class='form-group'>
															<label>Medicamentos Utilizados:</label>
															<input class='form-control' name='medicamento_usados' type='text' placeholder='' />
														</div>


													</div>
													<div class='col-md-4'>

														<div class='form-group'>
															<label>Mãe:</label>
															<input class='form-control' name='mae_animal' type='text' placeholder='' />
														</div>
														<div class='form-group'>
															<label>Data de Chegada:</label>
															<input class='form-control' name='data_chegada' type='date' placeholder='DD/MM/AAAA' />
														</div>

														<div class='form-group'>
															<label>Foto do animal:</label>
															<div class='form-group'>
																<input type='file' />
															</div>
														</div>


													</div>
												</div>
											</div>
											<div class='modal-footer'>
												<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
												<button type='submit' class='btn btn-primary'>Editar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							@endforeach	
					</div>

				</div>
			</div>
			<!--End Advanced Tables -->
		</div>
	</div>
	</div>

@endsection

