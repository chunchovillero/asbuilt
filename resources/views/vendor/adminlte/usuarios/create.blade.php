@extends('adminlte::layouts.app')




@section('main-content')



<section class="content-header" style="clear: both;">
	<h1>
		Crear usuario
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{route('usuarios.index')}}"><i class="fa fa-dashboard"></i> Usuarios</a></li>
		<li class="active">Crear Usuarios</li>
	</ol>
</section>
<section class="content" style="clear: both;">
	<form role="form" enctype="multipart/form-data" action="{{route('usuarios.store')}}" method="post">
		{{ csrf_field() }}
		<div class="box-body">
			<div class="form-group">
				@if($errors->has('nombre'))
					<span class="help-block">{{ $errors->first('nombre') }}</span>
		        @endif
				<label for="nombre">Nombre</label>
				<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
			</div>
			<div class="form-group">
				@if($errors->has('apellido'))
					<span class="help-block">{{ $errors->first('apellido') }}</span>
		        @endif
				<label for="apellido">apellido</label>
				<input type="text" class="form-control" id="apellido" name="apellido" placeholder="apellido">
			</div>
			<div class="form-group">

				@if($errors->has('email'))
					<span class="help-block">{{ $errors->first('email') }}</span>
		        @endif
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Email">
			</div>

			<div class="form-group">
				<label for="telefono">Teléfono</label>
				<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
			</div>

			<div class="form-group">
				<label for="posicion">Posición</label>
				<input type="text" class="form-control" id="posicion" name="posicion" placeholder="Posición">
			</div>

			<div class="form-group">
				<label for="admin">¿Administrador?</label>
				<select name="admin" id="admin">
					<option value="0" selected="">No</option>
					<option value="1">Si</option>
				</select>
			</div>

			<div class="form-group">
				<label for="creditos">Creditos</label>
				<input type="text" class="form-control" id="creditos" name="creditos" placeholder="Creditos">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
		</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Crear Usuario</button>
			</div>
		</form>

	</section>

@endsection