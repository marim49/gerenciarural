@extends('layouts.layout') @section('content')

<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Animal</h3>
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
					Buscar por Animais
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Grupo</th>
									<th>Fazenda</th>
									<th>Nascimento</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($fazendas))
								@foreach ($animais as $animal)
								<tr class='gradeA'>
									<td> {{$animal->nome}} </td>
									<td> {{$animal->GrupoAnimal->nome}} </td>
									<td> {{$animal->Fazenda->nome}} </td>
									<td> {{$animal->nascimento}} </td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-warning" onclick="editarAnimal()" data-toggle="modal" data-target="#exampleModal"
											    data-nome="{{$animal->nome}}" data-id="{{$animal->id}}" data-nomemae="{{$animal->nome_mae}}"
												data-nomepai"{{$animal->nome_pai}}" data-nascimento="{{$animal->nascimento}}"
												data-grupoanimal="{{$animal->id_grupo_animal}}" data-entrada="{{$animal->entrada}}"
												data-fazenda="{{$animal->id_fazenda}}">Editar</button>
										</center>
									</td>
								</tr>
								@endforeach
								@endif

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
									<h4 class="modal-title" id="exampleModalLabel">Curso</h4>
								</div>
								<div class="modal-body">								
								
									@if(isset($animal))
									<form name='update-animal' action="{{ route('animal.update', $animal->id) }}" method='POST'>
										{{ csrf_field() }} {{ method_field('PUT') }}
										<div class="panel-body">
											<div class="row">
												<div class="col-md-8">

													<div class="form-group">
														<label>Fazenda: *</label>
														<select class="form-control" id="fazenda" name="id_fazenda" />
															@foreach($fazendas as $fazenda)
																@if (old('id_fazenda') == $fazenda->id)
																<option value="{{$fazenda->id}}" selected>{{$fazenda->nome}}</option>
																@else
																<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
																@endif
															@endforeach
														</select>
													</div>

													<div class="form-group">
														<label>Identificão do Animal: *</label>
														<input class="form-control" id="nome" name="nome" type="text" placeholder="" maxlength="45" value="{{ old('nome')}}" />
													</div>

													<div class="form-group">
														<label>Grupo do animal: *</label>
														<select class="form-control" id="grupoanimal" name="id_grupo_animal">
															@foreach($grupos as $item)
															<option value="{{$item->id}}">{{$item->nome}}</option>
															@endforeach
														</select>
													</div>

													<div class="form-group">
														<label>Data de entrada: *</label>
														<input class="form-control" id="entrada" name="entrada" type="date" placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('entrada')}}"
														/>
													</div>

													<div class="form-group">
														<label>Data de Nascimento:</label>
														<input class="form-control" id="nascimento" name="nascimento" type="date" placeholder="DD/MM/AAAA" maxlength="45" value="{{ old('nascimento')}}"
														/>
													</div>

													<div class="form-group">
														<label>Identificão da mãe:</label>
														<input class="form-control" id="nomemae" name="nome_mae" type="text" placeholder="" maxlength="45" value="{{ old('nome_mae')}}" />
													</div>

													<div class="form-group">
														<label>Identificão do pai:</label>
														<input class="form-control" id="nomepai" name="nome_pai" type="text" placeholder="" maxlength="45" value="{{ old('nome_pai')}}" />
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
<!--End Advanced Tables -->
</div>
</div>
</div>

@endsection