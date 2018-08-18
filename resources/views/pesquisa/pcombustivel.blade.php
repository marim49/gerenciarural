@extends('layouts.layout') @section('content')
<div class="container">
	<div class="row pad-botm">
		<div class="col-md-12">
			<h3 class="header-line">Combustível</h3>
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
									<th>Fazenda</th>
									<th>Estoque (Diesel)</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($combustiveis)) @foreach ($combustiveis as $combustivel)
								<tr class='gradeA'>
									<td> {{$combustivel->Fazenda->nome}} </td>
									<td> {{$combustivel->quantidade}} </td>
								</tr>
								@endforeach @endif
							</tbody>
						</table>
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