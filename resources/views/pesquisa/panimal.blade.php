@extends('layouts.layout') @section('content')

<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Animais</h3>
			@if ($errors->any())
			<div class="alert alert-warning alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Ops!</strong> {{$errors->first()}}.
			</div>
			@endif @if (session()->has('success'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Salvo!</strong> Os dados foram salvos.
			</div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Grupo</th>
									<th>Fazenda</th>
									<th>Entrada</th>
									<th>Nascimento</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($animais as $animal)
								<tr class='gradeA'>
									<td> {{$animal->nome}} </td>
									<td> {{$animal->GrupoAnimal->nome}} </td>
									<td> {{$animal->Fazenda->nome}} </td>
									<td> {{$animal->entradaconvert}} </td>
									<td> {{$animal->nascimentoconvert}} </td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-warning" onclick="editarAnimal()" data-toggle="modal" data-target="#exampleModal"
											    data-nome="{{$animal->nome}}" data-id="{{$animal->id}}" data-nomemae="{{$animal->nome_mae}}" data-nomepai
											    "{{$animal->nome_pai}}" data-nascimento="{{$animal->nascimento}}" data-grupoanimal="{{$animal->id_grupo_animal}}" data-entrada="{{$animal->entrada}}"
											    data-fazenda="{{$animal->id_fazenda}}" data-route="animal">Editar</button>
										</center>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title" id="exampleModalLabel">Editar</h4>
								</div>
								<div class="modal-body">

									@if(isset($animal))
									<form id="editar" name="update-animal" method='POST'>
										{{ csrf_field() }} {{ method_field('PUT') }}
										<div class="panel-body">
											<div class="row">

												<div class="col-md-8">
													<div class="form-group">
														<label>Fazenda:</label>
														<select class="form-control" required id="fazenda" name="id_fazenda" /> @foreach($fazendas as $fazenda)
														<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
														@endforeach
														</select>
													</div>

													<div class="form-group">
														<label>Nome:</label>
														<input class="form-control" id="nome" required name="nome" type="text" placeholder="Identificação do animal" maxlength="45"
														/>
													</div>

													<div class="form-group">
														<label>Grupo do animal:</label>
														<select class="form-control" id="grupoanimal" required name="id_grupo_animal">
															@foreach($grupos as $item)
															<option value="{{$item->id}}">{{$item->nome}}</option>
															@endforeach
														</select>
													</div>

													<div class="form-group">
														<label>Data de entrada:</label>
														<input class="form-control" id="entrada" required name="entrada" type="date" placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('entrada')}}"
														/>
													</div>

													<div class="form-group">
														<label>Data de Nascimento:</label>
														<input class="form-control" id="nascimento" name="nascimento" type="date" placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('nascimento')}}"
														/>
													</div>

													<div class="form-group">
														<label>Mãe:</label>
														<input class="form-control" id="nomemae" name="nome_mae" type="text" placeholder="Identificação da mãe" maxlength="45" value="{{ old('nome_mae')}}"
														/>
													</div>

													<div class="form-group">
														<label>Pai:</label>
														<input class="form-control" id="nomepai" name="nome_pai" type="text" placeholder="Identificação do pai" maxlength="45" value="{{ old('nome_pai')}}"
														/>
													</div>
												</div>
											</div>
										</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
											<button type='submit' class='btn btn-primary'>Editar</button>
										</div>
									</form>
									@endif

								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>

@endsection