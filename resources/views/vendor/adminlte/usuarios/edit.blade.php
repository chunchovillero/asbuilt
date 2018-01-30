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

@if (Session::has('message'))

  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Perfecto!</h4>
    {{ Session::get('message') }}.
  </div>
  @endif
</section>
<section class="content" style="clear: both;">
	<form role="form" enctype="multipart/form-data" action="{{route('usuarios.update', '16')}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')}}
		<div class="box-body">
			<div class="form-group">
				@if($errors->has('nombre'))
					<span class="help-block">{{ $errors->first('nombre') }}</span>
		        @endif
				<label for="nombre">Nombre</label>
				<input type="text" class="form-control" value="{{$usuario->user_name}}" name="nombre" id="nombre" placeholder="Nombre">
			</div>
			<div class="form-group">
				@if($errors->has('apellido'))
					<span class="help-block">{{ $errors->first('apellido') }}</span>
		        @endif
				<label for="apellido">apellido</label>
				<input type="text" class="form-control" value="{{$usuario->user_last_name}}" id="apellido" name="apellido" placeholder="apellido">
			</div>
			<div class="form-group">

				@if($errors->has('email'))
					<span class="help-block">{{ $errors->first('email') }}</span>
		        @endif
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" value="{{$usuario->user_email}}" name="email" placeholder="Email">
			</div>

			<div class="form-group">
				<label for="telefono">Teléfono</label>
				<input type="text" class="form-control" value="{{$usuario->user_phone}}" id="telefono" name="telefono" placeholder="Teléfono">
			</div>

			<div class="form-group">
				<label for="posicion">Posición</label>
				<input type="text" class="form-control" id="posicion" value="{{$usuario->user_position}}" name="posicion" placeholder="Posición">
			</div>

			<div class="form-group">
				<label for="admin">¿Administrador?</label>
				<select name="admin" id="admin">
					<option value="0" @if($usuario->user_admin == 0) selected @endif>No</option>
					<option value="1" @if($usuario->user_admin == 1) selected @endif>Si</option>
				</select>
			</div>

			<div class="form-group">
				<label for="creditos">Creditos</label>
				<input type="text" class="form-control" value="{{$usuario->user_credit}}" id="creditos" name="creditos" placeholder="Creditos">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
		</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Editar Usuario</button>
			</div>
		</form>

	</section>

@endsection