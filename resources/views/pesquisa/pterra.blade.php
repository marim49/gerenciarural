@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Terras</h3>
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
					Buscar por Terras
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Tamanho da área</th>
									<th>Fazenda</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
							@if(isset($terras))
								@foreach ($terras as $terra)
								<tr class='gradeA'>
									<td> {{$terra->nome}} </td>
									@if($terra->area)
									<td> {{$terra->area}} </td>
									@else
									<td>
										<center>-</center>
									</td>
									@endif
									<td> {{$terra->Fazenda->nome}} </td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-warning" onclick="editarTerra()" data-toggle="modal" data-target="#exampleModal"
											    data-nome="{{$terra->nome}}" data-id="{{$terra->id}}" data-fazenda="{{$terra->id_fazenda}}" data-area="{{$terra->area}}">Editar</button>
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
									@if(isset($terra))
									<form name="register-terra" action="{{ route('terra.update', $terra->id) }}" method="post">
										{{ csrf_field() }}
										<div class="panel-body">
											<div class="row">


												<div class="col-md-8">
													<div class="form-group">
														<label>Fazenda: *</label>
														<select class="form-control" id="fazenda" name="id_fazenda">
															@foreach($fazendas as $fazenda) @if (old('id_fazenda') == $fazenda->id)
															<option value="{{$fazenda->id}}" selected>{{$fazenda->nome}}</option>
															@else
															<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
															@endif @endforeach
														</select>
													</div>
												</div>

												<div class="col-md-8">
													<div class="form-group">
														<label>Nome da terra: *</label>
														<input class="form-control" type="text" id="nome" name="nome" maxlength="45" value="{{old('nome')}}" />
													</div>
												</div>

												<div class="col-md-8">
													<div class="form-group">
														<label>Área:</label>
														<input class="form-control" type="text" id="area" name="area" value="{{ old('area')}}" />
													</div>
												</div>

											</div>
											<div class="right-div">
												<button type="submit" class="btn btn-info pull-right">Salvar </button>
											</div>
											<div class="right-div">
												<button type="reset" class="btn btn-info pull-right">Limpar </button>
											</div>
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
	<!--End Advanced Tables -->
</div>
</div>
</div>

@endsection