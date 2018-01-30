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
  <a href="{{ route('usuarios.create')}}" class="btn btn-primary pull-left">Crear Usuario</a>
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
    <div class="col-md-12">

      <div class="box">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Nombre</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Apellido  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Emai</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Teléfono</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Credito</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Posición</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Editar</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Eliminar</th>
                </tr>
              </thead>
              <tbody>

              @foreach($usuarios as $usuario)
                <tr role="row" class="odd">
                  <td>{{$usuario->user_name}}</td>
                  <td>{{$usuario->user_last_name}}</td>
                  <td>{{$usuario->user_email}}</td>
                  <td>{{$usuario->user_phone}}</td>
                  <td>{{$usuario->user_credit}}</td>
                  <td>{{$usuario->user_position}}</td>
                  <td><a href="{{route('usuarios.ver',$usuario->user_id)}}">Editar</a></td>
                  <td><a href="{{route('usuarios.eliminar',$usuario->user_id)}}">Eliminar</a></td>
                </tr>
              @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>

  </div>
</div>

</section>




@endsection
