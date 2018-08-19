 @extends('layouts.layout') @section('content')
<div class="container">
	<div class="col-md-12">
		<div class="row pad-botm">
			<h3 class="header-line">Cadastrar Animais</h3>
			@if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Cadastrado!</strong> O animal foi armazenado.
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
					Cadastre o animal inserindo-o nos campos abaixo:
				</div>

				<form name="register-animal" action="{{ route('animal.store') }}" method="post">
					{{ csrf_field() }}
					<div class="panel-body">
						<div class="row">
							<div class="col-md-8">

								<div class="form-group">
									<label>Fazenda:</label>
									<select class="form-control" name="id_fazenda" required/>
									<option value="" disabled selected>- Selecione uma fazenda -</option>
									@foreach($fazendas as $fazenda) @if (old('id_fazenda') == $fazenda->id)
									<option value="{{$fazenda->id}}" selected>{{$fazenda->nome}}</option>
									@else
									<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
									@endif @endforeach
									</select>
								</div>

								<div class="form-group">
									<label>Nome:</label>
									<input class="form-control" name="nome" required type="text" placeholder="Identificação do animal" maxlength="45" value="{{ old('nome')}}"
									/>
								</div>

								<div class="form-group">
									<label>Grupo do animal:</label>
									<select class="form-control" name="id_grupo_animal">
										<option value="" disabled selected>- Selecione um grupo de animal -</option>
										@foreach($grupos as $item)
										<option value="{{$item->id}}">{{$item->nome}}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label>Data de entrada:</label>
									<input class="form-control" name="entrada" required type="date" placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('entrada')}}"
									/>
								</div>

								<div class="form-group">
									<label>Data de Nascimento:</label>
									<input class="form-control" name="nascimento" type="date" placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('nascimento')}}"
									/>
								</div>

								<div class="form-group">
									<label>Identificão da mãe:</label>
									<input class="form-control" name="nome_mae" type="text" placeholder="Nome da mãe" maxlength="45" value="{{ old('nome_mae')}}"
									/>
								</div>

								<div class="form-group">
									<label>Identificão do pai:</label>
									<input class="form-control" name="nome_pai" type="text" placeholder="Nome do pai" maxlength="45" value="{{ old('nome_pai')}}"
									/>
								</div>
							</div>

							<div class="col-md-12">
								<div class="right-div">
									<button type="submit" class="btn btn-info pull-right">Salvar </button>
								</div>
								<div class="right-div">
									<button type="reset" class="btn btn-info pull-right">Limpar </button>
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