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
    @foreach($proyectos as $proyecto)
    <div class="col-md-3">
      <!-- Widget: user widget style 1 -->
      <a href="{{route('proyectos.ver', $proyecto->pro_id) }}">
        <div class="box box-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-aqua-active">
            <h3 class="widget-user-username">{{ $proyecto->pro_name}}</h3>
            <h5 class="widget-user-desc">{{ $proyecto->pro_company}}</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Avatar">
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{count($proyecto->usuarios)}}</h5>
                  <span class="description-text">Usuarios</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">Dirección</h5>
                  <span class="description-text">{{ $proyecto->pro_address }}</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </a>
      <!-- /.widget-user -->
    </div>
    @endforeach
  </div>

</section>

<script>

  $('#my-box').boxWidget({
    animationSpeed: 500,
    collapseTrigger: '#my-collapse-button-trigger',
    removeTrigger: '#my-remove-button-trigger',
    collapseIcon: 'fa-minus',
    expandIcon: 'fa-plus',
    removeIcon: 'fa-times'
  })

</script>



@endsection
