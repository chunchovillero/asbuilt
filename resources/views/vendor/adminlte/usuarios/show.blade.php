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
      <br>
      <a href="{{ route('proyectos.create')}}" class="btn btn-primary pull-left">Crear Proyecto</a>
      <br><br>
        @if (Session::has('message'))
                 
                 <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Perfecto!</h4>
                        {{ Session::get('message') }}.
                      </div>
             @endif

    </section>

<section class="content" style="clear: both;">
	<div class="row auto-clear">

</div>

</section>




@endsection
