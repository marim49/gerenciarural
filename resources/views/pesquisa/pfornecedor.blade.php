 @extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Pesquisar Fornecedor</h3>
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
					Buscar por Fornecedor
				</div>
				<div class="panel-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Telefone</th>
									<th>Editar</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($fornecedores))
								@foreach ($fornecedores as $fornecedor)
								<tr class='gradeA'>
									<td> {{$fornecedor->nome}} </td>
									<td> {{$fornecedor->telefone}} </td>
									<td>
										<center>
											<button type="button" class="btn btn-xs btn-warning" onclick="editarFornecedor()" data-toggle="modal" data-target="#exampleModal"
											    data-nome="{{$fornecedor->nome}}" data-id="{{$fornecedor->id}}" data-telefone="{{$fornecedor->telefone}}">Editar</button>
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
								
									@if(isset($fornecedor))
									<form name='update-fornecedor' action="{{ route('fornecedor.update', $fornecedor->id) }}" method='POST'>
										{{ csrf_field() }} {{ method_field('PUT') }}
										<div class="panel-body">
											<div class="row">
												<div class="col-md-12">

													<div class="col-md-8">
														<div class="form-group">
															<label>Nome: *</label>
															<input class="form-control" id="nome" type="text" name="nome" placeholder="Insira aqui o nome do fornecedor" maxlength="45" value="{{ old('nome')}}"
															/>
														</div>
													</div>

													<div class="col-md-8">
														<div class="form-group">
															<label>Telefone: *</label>
															<input class="form-control" id="telefone" type="text" name="telefone" placeholder="(__)____-____" maxlength="45" value="{{ old('telefone')}}"
															/>
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