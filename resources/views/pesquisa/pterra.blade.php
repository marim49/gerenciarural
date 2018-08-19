@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Terras</h3>
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
									<th>Tamanho da área</th>
									<th>Fazenda</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($terras)) @foreach ($terras as $terra)
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
											    data-nome="{{$terra->nome}}" data-id="{{$terra->id}}" data-fazenda="{{$terra->id_fazenda}}" data-area="{{$terra->area}}"
											    data-route="terra">Editar</button>
										</center>
									</td>
								</tr>
								@endforeach @endif
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

									@if(isset($terra))
									<form id="editar" name="register-terra" method="post">
										{{ csrf_field() }} {{ method_field('PUT') }}
										<div class="panel-body">
											<div class="row">

												<div class="col-md-8">
													<div class="form-group">
														<label>Fazenda:</label>
														<select class="form-control" required id="fazenda" name="id_fazenda">
															@foreach($fazendas as $fazenda)
															<option value="{{$fazenda->id}}">{{$fazenda->nome}}</option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="col-md-8">
													<div class="form-group">
														<label>Nome da terra: </label>
														<input class="form-control" type="text" id="nome" required name="nome" maxlength="45" />
													</div>
												</div>

												<div class="col-md-8">
													<div class="form-group">
														<label>Área:</label>
														<input class="form-control" type="text" id="area" name="area" />
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
</div>
</div>
</div>

@endsection