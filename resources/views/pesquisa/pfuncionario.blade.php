 @extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Funcionário</h3>
			@if ($errors->any())
			<div class="alert alert-warning alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Ops!</strong> {{$errors->first()}}.
			</div>
			@endif
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
									<th>Fazenda</th>
									<th>Celular</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($funcionarios as $funcionario)
								<tr class='gradeA'>
									<td>
										<span>
											<a href="" style="text-decoration:red;">{{$funcionario->nome}} </a>
										</span>
									</td>
									<td> {{$funcionario->cargo}} </td>
									<td> {{$funcionario->Fazenda->nome}} </td>
									<td> {{$funcionario->celular}}</td>
									<td>
										<button type="button" class="btn btn-xs btn-warning" onclick="editarFuncionario()" data-toggle="modal" data-target="#exampleModal"
										data-nome="{{$funcionario->nome}}" data-id="{{$funcionario->id}}" data-pis="{{$funcionario->pis}}"
										data-rg="{{$funcionario->rg}}" data-cpf="{{$funcionario->cpf}}" data-tel="{{$funcionario->tel_fixo}}"
										data-celular="{{$funcionario->celular}}" 
										data-nascimento="{{$funcionario->nascimento}}" data-rua="{{$funcionario->endereco_rua}}"
										data-numero="{{$funcionario->endereco_numero}}" data-bairro="{{$funcionario->endereco_bairro}}"
										data-cidade="{{$funcionario->endereco_cidade}}" data-estado="{{$funcionario->endereco_estado}}"
										data-pais="{{$funcionario->endereco_pais}}" data-cep="{{$funcionario->cep}}"
										data-admissao="{{$funcionario->admissao}}" data-fazenda="{{$funcionario->id_fazenda}}"
										data-cargo="{{$funcionario->cargo}}" data-estadocivil="{{$funcionario->EstadoCivil->id}}"
										data-sexo="{{$funcionario->sexo}}"
										>Editar</button>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
				</div>
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="exampleModalLabel">Curso</h4>
							</div>
							<div class="modal-body">
							<form name="register-funcionario" action="{{ route('funcionario.update', $funcionario->id ) }}" method="POST">
										{{ csrf_field() }} {{ method_field('PUT') }}
										<div class="panel-body">

											<div class="form-group">
												<label>Fazenda:</label>
												<div class="form-group">
													<select class="form-control" id="fazenda" name="id_fazenda">
														@foreach($fazendas as $fazenda)
														<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
														@endforeach
													</select>
												</div>
											</div>

											<div class="row">
												<div class="col-md-4">

													<div class="form-group">
														<label>Nome do Funcionário:</label>
														<input class="form-control" id="nome" name="nome" type="text" placeholder="Insira aqui o nome completo do funcionário" />
													</div>
													<div class="form-group">
														<label>RG:</label>
														<input class="form-control" id="rg" name="rg" type="text" placeholder="Insira aqui o RG do funcionário" />
													</div>
													<div class="form-group">
														<label>Estado Civil:</label>
														<div class="form-group">
															<select class="form-control" id="estadocivil" name="id_estado_civil">
																@foreach($grupos as $item)
																<option value="{{$item->id}}">{{$item->nome}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="form-group">
														<label>Rua:</label>
														<input class="form-control" type="text" id="endereco_rua" name="endereco_rua" placeholder="Insira aqui o endereço do funcionário" />
													</div>
													<div class="form-group">
														<label>Bairro:</label>
														<input class="form-control" type="text" id="endereco_bairro" name="endereco_bairro" placeholder="Insira aqui o bairro do funcionário" />
													</div>
													<div class="form-group">
														<label>País:</label>
														<input class="form-control" id="endereco_pais" name="endereco_pais" type="text" placeholder="Insira aqui o país do funcionário" />
													</div>

												</div>

												<div class="col-md-4">

													<div class="form-group">
														<label>Sexo:</label>
														<div class="radio">
															<div class="col-md-4">
																<label>
																	<input type="radio" name="sexo" id="sexo" value="feminino" checked="">Feminino
																</label>
															</div>
															<div class="col-md-6">
																<label>
																	<input type="radio" name="sexo" id="sexo" value="masculino" checked="">Masculino
																</label>
															</div>
														</div>

													</div>
													<div class="form-group">
														<label>CPF:</label>
														<input class="form-control" id="cpf" name="cpf" type="text" placeholder="Insira aqui o CPF" />
													</div>
													<div class="form-group">
														<label>Data de Nascimento:</label>
														<input class="form-control" id="dnascimento" name="nascimento" type="date" placeholder="DD/MM/AAAA" />
													</div>
													<div class="form-group">
														<label>Nº:</label>
														<input class="form-control" id="endereco_numero" name="endereco_numero" type="text" placeholder="Insira aqui o número da casa" />
													</div>
													<div class="form-group">
														<label>Cidade:</label>
														<input class="form-control" id="endereco_cidade" name="endereco_cidade" type="text" placeholder="Insira aqui a cidade do funcionário" />
													</div>
													<div class="form-group">
														<label>Cargo:</label>
														<input class="form-control" id="cargo" type="text" name="cargo" placeholder="Insira aqui a função do funcionário" />
													</div>

												</div>

												<div class="col-md-4">

													<div class="form-group">
														<label>PIS:</label>
														<input class="form-control" id="pis" name="pis" type="text" placeholder="PIS" />
													</div>

													<div class="form-group">
														<label>Telefone:</label>
														<input class="form-control" id="tel_fixo" name="tel_fixo" type="text" placeholder="(__)____-____" maxlength="16" />
													</div>

													<div class="form-group">
														<label>Celular</label>
														<input class="form-control" id="celular" name="celular" type="text" placeholder="(__)_____-____" maxlength="16" />
													</div>

													<div class="form-group">
														<label>Estado:</label>
														<div class="form-group">
															<select class="form-control" id="endereco_estado" name="endereco_estado">
																<option value="AC">Acre</option>
																<option value="AL">Alagoas</option>
																<option value="AP">Amapá</option>
																<option value="AM">Amazonas</option>
																<option value="BA">Bahia</option>
																<option value="CE">Ceará</option>
																<option value="DF">Distrito Federal</option>
																<option value="ES">Espírito Santo</option>
																<option value="GO">Goiás</option>
																<option value="MA">Maranhão</option>
																<option value="MT">Mato Grosso</option>
																<option value="MS">Mato Grosso do Sul</option>
																<option value="MG">Minas Gerais</option>
																<option value="PA">Pará</option>
																<option value="PB">Paraíba</option>
																<option value="PR">Paraná</option>
																<option value="PE">Pernambuco</option>
																<option value="PI">Piauí</option>
																<option value="RJ">Rio de Janeiro</option>
																<option value="RN">Rio Grande do Norte</option>
																<option value="RS">Rio Grande do Sul</option>
																<option value="RO">Rondônia</option>
																<option value="RR">Roraima</option>
																<option value="SC">Santa Catarina</option>
																<option value="SP">São Paulo</option>
																<option value="SE">Sergipe</option>
																<option value="TO">Tocantins</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label>CEP:</label>
														<input class="form-control" id="cep" name="cep" type="text" placeholder="CEP" />
													</div>
													<div class="form-group">
														<label>Data de Admissão:</label>
														<input class="form-control" id="admissao" name="admissao" type="date" placeholder="DD/MM/AAAA" />
													</div>
												</div>
												<a onclick="imprimir()" class="btn btn-primary pull-left">Imprimir</a>
												<div class="right-div">
													<button type="submit" class="btn btn-info pull-right">Salvar </button>
												</div>
												<div class="right-div">
													<button type="reset" class="btn btn-info pull-right">Limpar </button>
												</div>

											</div>
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
<!--End Advanced Tables -->
</div>
</div>
</div>

@endsection