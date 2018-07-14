 @extends('layouts.layout')
 @section('content')


<!-- MENU SECTION END-->
<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Funcionários</h3>
			@if (isset($success))
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Cadastrado!</strong> O funcionário foi armazenado.
				</div>
			@endif
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
			<div class="panel panel-default">
				<div class="panel-heading">
					Insira os dados para cadastrar um funcionário:
				</div>
				<form name="register-funcionario" action="{{ route('funcionario.store') }}" method="post">
					{{ csrf_field() }}
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">

								<div class="form-group">
									<label>Nome do Funcionário:</label>
									<input class="form-control" name="nome" type="text" placeholder="Insira aqui o nome completo do funcionário" />
								</div>
								<div class="form-group">
									<label>RG:</label>
									<input class="form-control" name="rg" type="text" placeholder="Insira aqui o RG do funcionário" />
								</div>
								<div class="form-group">
									<label>Estado Civil:</label>
									<div class="form-group">
										<select class="form-control" name="id_estado_civil">
										@foreach($grupos as $item)
											<option value="{{$item->id}}">{{$item->nome}}</option>
										@endforeach
										</select>
									</div>
								</div>
								<div class="form-group">
									<label>Rua:</label>
									<input class="form-control" type="text" name="endereco_rua" placeholder="Insira aqui o endereço do funcionário" />
								</div>
								<div class="form-group">
									<label>Bairro:</label>
									<input class="form-control" type="text" name="endereco_bairro" placeholder="Insira aqui o bairro do funcionário" />
								</div>															
								<div class="form-group">
									<label>País:</label>
									<input class="form-control" name="endereco_pais" type="text" placeholder="Insira aqui o país do funcionário" />
								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">
									<label>Sexo:</label>
									<div class="radio">
										<div class="col-md-4">
											<label>
												<input type="radio" name="sexo" id="optionsRadios1" value="feminino" checked="">Feminino
											</label>
										</div>
										<div class="col-md-6">
											<label>
												<input type="radio" name="sexo" id="optionsRadios1" value="masculino" checked="">Masculino
											</label>
										</div>
									</div>

								</div>
								<div class="form-group">
									<label>CPF:</label>
									<input class="form-control" name="cpf" type="text" placeholder="Insira aqui o CPF" />
								</div>
								<div class="form-group">
									<label>Data de Nascimento:</label>
									<input class="form-control" name="nascimento" type="date" placeholder="DD/MM/AAAA" />
								</div>
								<div class="form-group">
									<label>Nº:</label>
									<input class="form-control" name="endereco_numero" type="text" placeholder="Insira aqui o número da casa" />
								</div>
								<div class="form-group">
									<label>Cidade:</label>
									<input class="form-control" name="endereco_cidade" type="text" placeholder="Insira aqui a cidade do funcionário" />
								</div>								
								<div class="form-group">
									<label>Cargo:</label>
									<input class="form-control" type="text" name="cargo" placeholder="Insira aqui a função do funcionário" />
								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">
									<label>PIS:</label>
									<input class="form-control" name="pis" type="text" placeholder="PIS" />
								</div>

								<div class="form-group">
									<label>Telefone:</label>
									<input class="form-control" name="tel_fixo" type="text" placeholder="(__)____-____" maxlength="16" />
								</div>

								<div class="form-group">
									<label>Celular</label>
									<input class="form-control" name="celular" type="text" placeholder="(__)_____-____" maxlength="16" />
								</div>

								<div class="form-group">
									<label>Estado:</label>
									<div class="form-group">
										<select class="form-control" name="endereco_estado">
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
									<input class="form-control" name="cep" type="text" placeholder="CEP" />
								</div>								
								<div class="form-group">
									<label>Data de Admissão:</label>
									<input class="form-control" name="admissao" type="date" placeholder="DD/MM/AAAA" />
								</div>
							</div>							

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
@endsection