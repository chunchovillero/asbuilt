@extends('adminlte::layouts.app')




@section('main-content')



<section class="content-header" style="clear: both;">
	<h1>
		Proyectos
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Proyectos</li>
	</ol>
</section>
<section class="content" style="clear: both;">
	<form role="form" enctype="multipart/form-data" action="{{route('proyectos.store')}}" method="post">
		{{ csrf_field() }}
		<div class="box-body">
			<div class="form-group">
				<label for="nombreproyecto">Nombre del proyecto</label>
				<input type="text" class="form-control" name="nombreproyecto" id="nombreproyecto" placeholder="Nombre del proyecto">
			</div>
			<div class="form-group">
				<label for="nombreempresa">Nombre de la empresa</label>
				<input type="text" class="form-control" id="nombreempresa" name="nombreempresa" placeholder="Nombre de la empresa">
			</div>
			<div class="form-group">
				<label for="direccion">Dirección</label>
				<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
			</div>

			<div class="form-group">
				<label for="latitud">Latitud</label>
				<input type="text" class="form-control" id="latitud" name="latitud" placeholder="Latitud">
			</div>

			<div class="form-group">
				<label for="longitud">Longitud</label>
				<input type="text" class="form-control" id="longitud" name="longitud" placeholder="Longitud">
			</div>
		</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Crear Proyecto</button>
			</div>
		</form>

	</section>

@endsection