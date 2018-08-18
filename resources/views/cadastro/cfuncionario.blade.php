 @extends('layouts.layout') @section('content')

<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Funcionários</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Cadastrado!</strong> O funcionário foi armazenado.
			</div>
			@endif @if ($errors->any())
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

						<div class="form-group">
							<label>Fazenda: *</label>
							<div class="form-group">
								<select class="form-control" name="id_fazenda">
									<option value="" disabled selected>- Selecione uma fazenda -</option>
									@foreach($fazendas as $fazenda) @if (old('id_fazenda') == $fazenda->id)
									<option value="{{$fazenda->id}}" selected>{{$fazenda->nome}}</option>
									@else
									<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
									@endif @endforeach
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">

								<div class="form-group">
									<label>Nome do Funcionário: *</label>
									<input class="form-control" name="nome" required maxlength="100" type="text" placeholder="Insira aqui o nome completo do funcionário" maxlength="100"
									    value="{{ old('nome')}}" />
								</div>
								<div class="form-group">
									<label>RG: *</label>
									<input class="form-control" name="rg" type="text" required maxlength="45" placeholder="Insira aqui o RG do funcionário" maxlength="45" value="{{ old('rg')}}"
									/>
								</div>
								<div class="form-group">
									<label>Estado Civil: *</label>
									<div class="form-group">
										<select class="form-control" name="id_estado_civil">
											@foreach($grupos as $item)
											<option value="{{$item->id}}">{{$item->nome}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group">
									<label>Rua: *</label>
									<input class="form-control" type="text" name="endereco_rua" required maxlength="45" placeholder="Insira aqui o endereço do funcionário" maxlength="45"
									    value="{{ old('endereco_rua')}}" />
								</div>
								<div class="form-group">
									<label>Bairro: *</label>
									<input class="form-control" type="text" name="endereco_bairro" required maxlength="45" placeholder="Insira aqui o bairro do funcionário" maxlength="45"
									    value="{{ old('endereco_bairro')}}" />
								</div>
								<div class="form-group">
									<label>País: *</label>
									<input class="form-control" name="endereco_pais" type="text" required maxlength="45" placeholder="Insira aqui o país do funcionário" maxlength="45"
									    value="{{ old('endereco_pais')}}" />
								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">
									<label>Sexo: *</label>
									<div class="radio">
										<div class="col-md-4">
											<label>
												<input type="radio" name="sexo" id="optionsRadios1" value="feminino" {{ (old('sexo') == 'feminino') ? 'checked' : '' }}>Feminino
											</label>
										</div>
										<div class="col-md-6">
											<label>
												<input type="radio" name="sexo" id="optionsRadios1" value="masculino" {{ (old('sexo') == 'masculino') ? 'checked' : '' }}>Masculino
											</label>
										</div>
									</div>

								</div>
								<div class="form-group">
									<label>CPF: *</label>
									<input class="form-control" name="cpf" type="text" required placeholder="Insira aqui o CPF" maxlength="45" value="{{ old('cpf')}}"
									/>
								</div>
								<div class="form-group">
									<label>Data de Nascimento: *</label>
									<input class="form-control" name="nascimento" type="date" required placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('nascimento')}}"
									/>
								</div>
								<div class="form-group">
									<label>Nº: *</label>
									<input class="form-control" name="endereco_numero" type="text" required placeholder="Insira aqui o número da casa" maxlength="45"
									    value="{{ old('endereco_numero')}}" />
								</div>
								<div class="form-group">
									<label>Cidade: *</label>
									<input class="form-control" name="endereco_cidade" type="text" required placeholder="Insira aqui a cidade do funcionário" maxlength="45"
									    value="{{ old('endereco_cidade')}}" />
								</div>
								<div class="form-group">
									<label>Cargo: *</label>
									<input class="form-control" type="text" name="cargo" required placeholder="Insira aqui a função do funcionário" maxlength="45" value="{{ old('cargo')}}"
									/>
								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">
									<label>PIS: *</label>
									<input class="form-control" name="pis" required type="text" placeholder="PIS" maxlength="45" value="{{ old('pis')}}" />
								</div>
								<div class="form-group">
									<label>Telefone: *</label>
									<input class="form-control" name="tel_fixo" required type="text" placeholder="(__)____-____" maxlength="45" value="{{ old('tel_fixo')}}"
									/>
								</div>
								<div class="form-group">
									<label>Celular: *</label>
									<input class="form-control" name="celular" required type="text" placeholder="(__)_____-____" maxlength="45" value="{{ old('celular')}}"
									/>
								</div>
								<div class="form-group">
									<label>Estado: *</label>
									<input class="form-control" name="endereco_estado" required type="text" placeholder="Insira aqui o estado" maxlength="45" value="{{ old('endereco_estado')}}"/>
								</div>
								<div class="form-group">
									<label>CEP: *</label>
									<input class="form-control" name="cep" required type="text" placeholder="CEP" maxlength="45" value="{{ old('cep')}}" />
								</div>
								<div class="form-group">
									<label>Data de Admissão: *</label>
									<input class="form-control" name="admissao" required type="date" placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('admissao')}}"
									/>
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