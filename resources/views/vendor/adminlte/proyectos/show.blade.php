@extends('adminlte::layouts.app')




@section('main-content')



<!-- Inicio funcion recorrer de proyecto-->
<?php 
function recorrer($meta, $life, $documentos, $proyecto){
?>
  <ul class="nav nav-tabs">
    <?php foreach ($life as $key) {
      if($key['idpadre']==$meta){
    ?>
      <li><a data-toggle='tab' href="#proy-<?php echo $key['id'] ?>"><?php echo $key['nombre'] ?></a></li>
    <?php }
      } 
    ?>
  </ul>

  <div class="tab-content">
    <?php 
    foreach ($life as $key) {
      if($key['idpadre']==$meta){
    ?>
        <div id="proy-<?php echo $key['id'] ?>" class="tab-pane fade in">
          <?php 
            $i=0;
            foreach ($life as $key2) {
              if($key['meta']==$key2['idpadre']){
                $i=$i+1;
              }
            }
          ?>

          <?php 
            if($i>0){
              recorrer($key['meta'], $life, $documentos, $proyecto);
            }?>
              <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>
            <?php 

            foreach($documentos as $documento){
                    if($documento->doc_pro_id==$proyecto->pro_id && $documento->doc_metadata==$key['meta']){
                      ?>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="{{ $documento->doc_file_path }}">
                          <div class="info-box">
                            <span class="info-box-icon  bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-number"><?php echo $documento->doc_name?></span>
                              </div>
                          </div>
                        </a>
                      </div>
                      <?php
                    }}
            ?></div>
            <?php 
            }
            ?>
        
  <?php }
  ?>
  </div> 
<?php }
?>

<!-- fin funcion recorrer de proyecto-->


<!-- inicio funcion recorrer option de select del proyecto -->
<?php 
function recorreroption($meta, $life){
  foreach ($life as $key) {
    $espacios="";
    $guiones="";
    if($key['idpadre']==$meta){
      for ($i=0; $i < $key['count'] ; $i++) { 
        $guiones .="-";
        $espacios .="&nbsp;&nbsp;&nbsp;&nbsp;";
      }
    ?>
        <option value='<?php echo $key['meta']?>'><?php echo $espacios.$guiones.$key['nombre'] ?></option>
    <?php
          recorreroption($key['meta'],$life);
    }
  }
}
?>
<!-- fin funcion recorrer option de select del proyecto -->

<!-- inicio funcion recorre piso -->

<?php 

function recorrerpiso($meta, $life, $documentos, $piso){

?>
  <ul class="nav nav-tabs">
    <?php 
    foreach ($life as $key) {
      if($key['idpadre']==$meta){
    ?>
    <li><a data-toggle='tab' href  ='#piso-{{$piso->sec_id}}-<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></a></li>
    <?php }} ?>
  </ul>

  <div class="tab-content">
    <?php 
    foreach ($life as $key) {
      if($key['idpadre']==$meta){
    ?>
        <div id='piso-{{$piso->sec_id}}-<?php echo $key['id'] ?>' class="tab-pane fade in">
    <?php 
     $i=0;
        foreach ($life as $key2) {
          if($key['meta']==$key2['idpadre']){
            $i=$i+1;
          }
        }
    ?>

    <?php 
    if($i>0){
      recorrerpiso($key['meta'], $life, $documentos, $piso);
    }?>

    <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>

    <?php foreach($documentos as $documento){
      if($documento->doc_sec_id==$piso->sec_id && $documento->doc_metadata==$key['meta']){
    ?>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ $documento->doc_file_path }}">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>
            <div class="info-box-content">
            <span class="info-box-number">{{ $documento->doc_name }}</span>
            </div>
          </div>
        </a>
      </div>
<?php }} ?>
  </div>
<?php }} ?>
</div>
<?php
}
?>

<!-- Fin funcion recorre piso -->

<!-- Inicio funcion reccore seccion -->
<?php 
function recorrerseccion($meta, $life, $documentos, $sala){

  ?>
  <ul class="nav nav-tabs">
    <?php foreach ($life as $key) {
      if($key['idpadre']==$meta){
        ?>
        <li><a data-toggle='tab' href  ='#seccion-{{$sala->fac_id}}-<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></a></li>
        <?php }} ?>
      </ul>

      <div class="tab-content">
        <?php 
        foreach ($life as $key) {
          if($key['idpadre']==$meta){
           ?>
            <div id='seccion-{{$sala->fac_id}}-<?php echo $key['id'] ?>' class="tab-pane fade in">
              <?php 
              $i=0;
              foreach ($life as $key2) {
                if($key['meta']==$key2['idpadre']){
                  $i=$i+1;
                }
              }
              ?>

              <?php 
              if($i>0){

                recorrerseccion($key['meta'], $life, $documentos, $sala);

              } ?>


              <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>

              <?php foreach($documentos as $documento){
                if($documento->doc_sec_id==$sala->fac_id && $documento->doc_metadata==$key['meta']){
                  ?>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ $documento->doc_file_path }}">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-number">{{ $documento->doc_name }}</span>

                        </div>
                        <!-- /.info-box-content -->
                      </div>
                    </a>
                    <!-- /.info-box -->
                  </div>
                  <?php }} ?>
               </div>
              <?php }} ?>
           </div>
    <?php
  }
?>


<!-- fin funcion recorre piso -->

<!-- inicio funcion recorre planta -->

<?php 

function recorrerplanta($meta, $life, $documentos, $planta){

  ?>
  <ul class="nav nav-tabs">
    <?php foreach ($life as $key) {
      if($key['idpadre']==$meta){
        ?>
        <li><a data-toggle='tab' href  ='#planta-{{$planta->flo_id}}-<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></a></li>
        <?php }} ?>
      </ul>

      <div class="tab-content">
        <?php 
        foreach ($life as $key) {
          if($key['idpadre']==$meta){

            ?>

            <div id='planta-{{$planta->flo_id}}-<?php echo $key['id'] ?>' class="tab-pane fade in">

              <?php 
              $i=0;
              foreach ($life as $key2) {
                if($key['meta']==$key2['idpadre']){
                  $i=$i+1;
                }
              }
              ?>

              <?php 
              if($i>0){

                recorrerplanta($key['meta'], $life, $documentos, $planta);

              } ?>


              <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>

              <?php foreach($documentos as $documento){
                if($documento->doc_flo_id==$planta->flo_id && $documento->doc_metadata==$key['meta']){
                  ?>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ $documento->doc_file_path }}">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-number">{{ $documento->doc_name }}</span>

                        </div>
                        <!-- /.info-box-content -->
                      </div>
                    </a>
                    <!-- /.info-box -->
                  </div>
                  <?php }} ?>

                </div>
                <?php }} ?>
              </div>


              <?php
            }

            ?>

<!-- fin funcion recorre piso -->


<!-- inicio seccion 1-->
<section class="content-header" style="clear: both;">
  <h1>
    Proyectos
  </h1>
  <!-- inicio bradcum -->
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Proyectos</li>
  </ol>
  <!-- fin breadcum -->
  
  <br>
  <!-- link hacia proyectos -->
  <a href="{{ route('proyectos.create')}}" class="btn btn-primary pull-left">Crear Proyecto</a>
  <br><br>
</section>
<!-- fin seccion 1-->


<section class="content" style="clear: both;">
  <div class="row auto-clear">
    <!-- inicio cuadro de informacion del proycto -->
    <div class="col-md-4">
      <div class="col-md-12">
        <a href="{{route('proyectos.ver', $proyecto->pro_id) }}">
          <div class="box box-widget widget-user">
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
                </div>
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Dirección</h5>
                    <span class="description-text">{{ $proyecto->pro_address }}</span>
                  </div>
                </div>
                
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">35</h5>
                    <span class="description-text">PRODUCTS</span>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
    <!-- fin cuadro informacion del proyecto -->
    <!-- inicio mapa -->
    <div class="col-md-8">
      <div class="box box-widget widget-user">
        <div class="google-maps">
          <iframe width="600" height="240" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?key=AIzaSyBLn3c9X7aZG7_jkl0yJXeOmx8buuTg7AU&q={{ $proyecto->pro_latitude }},{{ $proyecto->pro_longitude }}" allowfullscreen></iframe>
        </div>
      </div>
    </div>
    <!-- fin mapa -->
  </div>
  
  <div class="row auto-clear">
    @if (Session::has('message1'))
      <div class="alert alert-success alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 20px; margin-bottom: 20px">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('message1') }}.
      </div>
    @endif

    @if (Session::has('message2'))
      <div class="alert alert-warning alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 20px; margin-bottom: 20px">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('message2') }}.
      </div>
    @endif

    @if (Session::has('message3'))
      <div class="alert alert-danger alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 20px; margin-bottom: 20px">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ Session::get('message3') }}.
      </div>
    @endif 
    <br>

    <div class="col-md-12">

      <!-- inicio archivos de proyecto -->
      <div class="box box-warning box-solid collapsed-box">
        <div class="box-header with-border"  data-widget="collapse">
          <h3 class="box-title">Archivos del proyecto</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>

        <div class="box-body">
          <div class="col-md-12">
            <!-- Inicio listado de archivos del proyecto -->
            <div class="row">
              <h1>Archivos</h1>
              <div class="container">
                <ul class="nav nav-tabs">
                <?php 
                $a=1;
                foreach ($life as $key) {
                  if($key['count']==1){
                ?>
                    <li <?php if($a==1){echo 'class="active"';} ?>><a data-toggle='tab' href='#proy-<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></a></li>
                <?php 
                  }
                  $a=$a+1;
                } 
                ?>
                </ul>



                <div class="tab-content">
                  <?php 
                  $b=1;
                  foreach ($life as $key) {
                    if($key['count']==1){
                  ?>
                      <div id="proy-<?php echo $key['id'] ?>" class="tab-pane fade in <?php if($b==1){echo 'active';} ?>">
                  <?php 
                  $i=0;
                  foreach ($life as $key2) {
                    if($key['meta']==$key2['idpadre']){
                    $i=$i+1;
                    }
                  }
                  if($i>0){
                    recorrer($key['meta'], $life, $documentos, $proyecto);
                  }?>

                  <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>
                  
                  @foreach($documentos as $documento)
                    @if($documento->doc_pro_id==$proyecto->pro_id && $documento->doc_metadata==$key['meta'])
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="{{ $documento->doc_file_path }}">
                          <div class="info-box">
                            <span class="info-box-icon  bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-number">{{ $documento->doc_name }}</span>
                              </div>
                          </div>
                        </a>
                      </div>
                    @endif

                  @endforeach

                </div>
              <?php }
              $b=$b+1;

            } ?>
              </div>
            </div>
            <!-- fin listado de archivos del proyecto -->
          <div>
              <hr>
          </div>
          <!-- inicio de subida de archivos del proyecto -->
          <h3 class="box-title">Subir Archivo</h3>
          <!-- caja de alerta de nuevo archivo de proyecto  -->
          <div class="col-md-12 col-sm-12 col-xs-12 success-proyecto-{{$proyecto->pro_id}}">
          </div>
        <!-- fin caja de alerta de nuevo archivo de proyecto  -->

      <!-- Inicio formulario de subida de archivos alproyecto -->
        <form name="subirdocproy-{{$proyecto->pro_id}}" role="form" class="target" enctype="multipart/form-data" action="{{route('documento.agregarproy',['proy' => $proyecto->pro_id, 'id' => $proyecto->pro_id])}}" method="post">

          <input type="hidden" value="proyecto" name="desde">
          <input type="hidden" value="{{$proyecto->pro_id}}" name="idproyecto">

          {{ csrf_field() }}

          <div class="col-md-4">
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" class="form-control">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="documento">Documento</label>
              <input type="file" name="documento-subirdocproy-{{$proyecto->pro_id}}" id="file-subirdocproy-{{$proyecto->pro_id}}" class="file form-control">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="nombre">Seleccionar Categoría</label>
              <select class="form-control" name="categoria" id="categoria">
                <option value="">Seleccione una categoria</option>
                <?php 
                  foreach ($life as $key) {
                    if($key['count']==1){
                  ?>
                      <option value='<?php echo $key['meta']?>'><?php echo $key['nombre']?></option>
                  <?php 
                        recorreroption($key['meta'], $life);
                  ?>

                  <?php }
                    $a=$a+1;
                  } ?>
              </select>        
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <p>O Cree una categoria Nueva</p>
              <label for="nombre">Seleccionar Categoría padre</label>
              <select class="form-control" name="categoria_padre" id="categoria_padre">
                <option value="">Sin Categoria Padre</option>
                <?php 
                  foreach ($life as $key) {
                    if($key['count']==1){
                ?>
                      <option value='<?php echo $key['meta']?>'><?php echo $key['nombre']?></option>
                <?php 
                        recorreroption($key['meta'], $life);
                    }
                  $a=$a+1;
                  } ?>


              </select>
              <label for="nombre">Nueva Categoria</label>
              <input type="text" name="nueva_categoria" id="nueva_categoria" placeholder="nueva_categoria" class="form-control">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <button type="submit" id="upload_btn" class="btn btn-primary">Subir documento al proyecto</button>
            </div>
          </div>
        </form>
        <!-- Fin formulario de subida de archivos alproyecto -->
        <br><br>
        <!-- fin subida de archivos del proyecto -->

        </div>
      </div>
    </div>
  </div>
</div>

<!-- inicio listados de usuarios del proyecto -->
<div class="col-md-12">
  <div class="box box-warning box-solid collapsed-box">
    <div class="box-header with-border" data-widget="collapse">
      <h3 class="box-title" style="float: left;">Listado de usuarios de este proyecto </h3>
        @if (Session::has('message'))
          <div class="alert alert-success alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 20px; padding-top: 0px; padding-bottom: 0px">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              {{ Session::get('message') }}.
          </div>
        @endif 
        <br>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
    </div>
  <div class="box-body">
    <form role="form" enctype="multipart/form-data" action="{{route('usuarios.agregar',$proyecto->pro_id)}}" method="post">
      {{ csrf_field() }}
      <div class="col-md-6">
        <div class="form-group">
          <label for="email">Ingrese el email del usuario a invitar</label>
          <input type="text" name="email" placeholder="Ingrese Email" id="email" class="form-control">
        </div>
      </div>

      <div class="col-md-6">
        <button type="submit" class="btn btn-primary">Agregar usuario al proyecto</button>
      </div>
    </form>
    <br>
    <!-- tabla listado de usuarios -->
    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
      <thead>
        <tr role="row">
          <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Nombre</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Apellido  </th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Email</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Teléfono</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Credito</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Posición</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Activo</th>
        </tr>
      </thead>
    <tbody>
    
    @foreach($proyecto->usuarios as $usuario)
        <tr role="row" class="odd">
          <td>{{$usuario->user_name}}</td>
          <td>{{$usuario->user_last_name}}</td>
          <td>{{$usuario->user_email}}</td>
          <td>{{$usuario->user_phone}}</td>
          <td>{{$usuario->user_credit}}</td>
          <td>{{$usuario->user_position}}</td>
          <td>
            @if($usuario->pivot->user_act=='1')
              <a href="{{route('usuarios.eliminar2',['userid' => $usuario->user_id, 'projectid'=>$proyecto->pro_id])}}" class="btn btn-success">Si, Desactivar</a> @endif
            @if($usuario->pivot->user_act=='0')
              <a href="{{route('usuarios.activar',['userid' => $usuario->user_id, 'projectid'=>$proyecto->pro_id])}}" class="btn btn-danger">No, Activar</a>
            @endif
          </td>
        </tr>
    @endforeach
    </table> 
  </div>
</div>
</div>

<!-- fin listado de usuarios del proyecto -->

<div class="col-md-12">
  @if (Session::has('plantanueva'))
    <div class="box box-warning box-solid" id="categorias">
  @elseif (Session::has('plantaeliminada'))
    <div class="box box-warning box-solid" id="categorias">
  @elseif (Session::has('pisonuevo'))
    <div class="box box-warning box-solid" id="categorias">
  @elseif (Session::has('salanueva'))
    <div class="box box-warning box-solid" id="categorias">
  @else
    <div class="box box-warning box-solid collapsed-box" id="categorias">
  @endif  
      
      <div class="box-header with-border" data-widget="collapse">
        <h3 class="box-title">Categorias</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
      </div>

      <div class="box-body">
        <div class="col-md-12 paddingleft0">
          <!-- Inicio alerta de planta eliminada -->
          @if (Session::has('plantaeliminada'))
            <div class="alert alert-danger alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 20px; margin-bottom: 20px">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('plantaeliminada') }}.
            </div>
            <div style="clear: both;"></div>
          @endif
          <!-- Fin alerta de planta eliminada -->
          
          <!-- Inicio alerta de planta creada -->
          @if (Session::has('plantanueva'))
            <div class="alert alert-success alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 20px; margin-bottom: 20px">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('plantanueva') }}.
            </div>
            <div style="clear: both;"></div>
          @endif
          <!-- Fin alerta de planta eliminada -->
          
          <!-- Inicio formulario creacion de planta -->
          <form class="crearcategoria" role="form" enctype="multipart/form-data" action="{{route('proyecto.crearplanta',['proy' => $proyecto->pro_id])}}" method="post">
            {{ csrf_field() }}
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="nombreplanta" placeholder="Nombre de la categoria" id="nombreplanta" class="form-control">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <button type="submit" class="btn btn-primary ">Crear Categoria</button>
              </div>
            </div>
          </form>
        </div>
        <h3 class="paddingleft15">Categorias del proyecto {{ $proyecto->pro_name }}</h3>
        <!-- Inicio de loop de plantas -->
        @foreach($plantas as $planta)
          <div class="col-md-12">
            @if (Session::has('pisonuevo'))
              @if (Session::get('planta')==$planta->flo_id)
                <div class="box box-warning box-solid" id="planta-{{$planta->flo_id}}">
              @else
                <div class="box box-warning box-solid collapsed-box" id="planta-{{$planta->flo_id}}">
              @endif
            @elseif (Session::has('salanueva'))
              @if (Session::get('idpiso')==$planta->flo_id)
                <div class="box box-warning box-solid" id="planta-{{$planta->flo_id}}">
              @else
                <div class="box box-warning box-solid collapsed-box" id="planta-{{$planta->flo_id}}">
              @endif
            @else
              <div class="box box-warning box-solid collapsed-box" id="planta-{{$planta->flo_id}}">
            @endif
              @if (Session::has('plantanueva'))
                @if(Session::get('idplantanueva')==$planta->flo_id) 
                  <div class="box-header with-border" style="background: olivedrab" data-widget="collapse">
                @else
                  <div class="box-header with-border" data-widget="collapse">
                @endif
              @else
                <div class="box-header with-border" data-widget="collapse">
              @endif
              <h3 class="box-title">{{$planta->flo_name}}</h3>  
              @if (Session::has('plantanueva'))
                @if(Session::get('idplantanueva')==$planta->flo_id)
                  ({{Session::get('mensaje')}})
                @endif
              @endif

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
          </div>
          <div class="box-body">

            <div class="row">
    
              <div class="" style="float: left; padding-right: 15px">
              <a href="{{route('copiarplanta',['proy' => $proyecto->pro_id, 'id' => $planta->flo_id])}}" class="margingleft15 btn btn-primary">Duplicar {{$planta->flo_name}} </a>
            </div>

              <div class="" style="float: left; padding-right: 15px">
                <a href="{{route('eliminarplanta',['proy' => $proyecto->pro_id, 'id' => $planta->flo_id])}}" class="btn btn-danger">Eliminar {{$planta->flo_name}} </a>
              </div>

              <div class="" style="float: left; padding-right: 15px; width: 300px">
                <form role="form" enctype="multipart/form-data" action="{{route('editarplanta',['proy' => $proyecto->pro_id, 'id'=> $planta->flo_id])}}" method="post">
                                      {{ csrf_field() }}

                             
                                      <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ingrese nombre" name="nombreplanta" value="{{$planta->flo_name}}">
                                        <span class="input-group-btn">
                                           <button type="submit" class="btn btn-primary">Editar Categoría</button>
                                        </span>
                                      </div><!-- /input-group -->
                                    </form>
              </div>
              <div style="clear: both;"></div>

              <h3 class="paddingleft15">Documentos de {{$planta->flo_name}}</h3>


              <!-- inicio categorias planta -->  
              <div class="paddingleft15"> 

                <ul class="nav nav-tabs">
                  <?php 
                  $a=1;
                  foreach ($life as $key) {
                    if($key['count']==1){
                      ?>
                      <li <?php if($a==1){echo 'class="active"';} ?>><a data-toggle='tab' href='#planta-{{$planta->flo_id}}-<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></a></li>
                      <?php }
                      $a=$a+1;
                    } ?>
                  </ul>


                  <div class="tab-content">

                    <?php 
                    $b=1;
                    foreach ($life as $key) {
                      if($key['count']==1){



                        ?>
                        <div id='planta-{{$planta->flo_id}}-<?php echo $key['id'] ?>' class="tab-pane fade in <?php if($b==1){echo 'active';} ?>">

                          <?php 
                          $i=0;
                          foreach ($life as $key2) {
                            if($key['meta']==$key2['idpadre']){
                              $i=$i+1;
                            }
                          }
                          ?>

                          <?php 
                          if($i>0){

                            recorrerplanta($key['meta'], $life, $documentos, $planta);

                          } ?>

                          <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>

                          <?php 
                          $aplantas=0;
                          ?>
                          @foreach($documentos as $documento)
                          @if($documento->doc_flo_id==$planta->flo_id && $documento->doc_metadata==$key['meta'])
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="{{ $documento->doc_file_path }}">
                              <div class="info-box">
                                <span class="info-box-icon  bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>

                                <div class="info-box-content">
                                  <span class="info-box-number">{{ $documento->doc_name }}</span>

                                </div>
                                <!-- /.info-box-content -->
                              </div>
                            </a>
                            <!-- /.info-box -->
                          </div>
                          <?php 
                          $aplantas=$aplantas+1;
                          ?>
                          @endif

                          @endforeach

                          <?php 
                          if($aplantas==0){
                            echo "<h3>No hay archivos para esta categoria.</h3>";
                          }
                          ?>



                        </div>
                        <?php }
                        $b=$b+1;} ?>

                      </div>
                    </div>




                    <div class="col-md-12 col-sm-12 col-xs-12 success-planta-{{$planta->flo_id}}">
                    </div>

                    <form name="subirdocplanta-{{$planta->flo_id}}" role="form" class="target" enctype="multipart/form-data" action="{{route('documento.agregarproy',['proy' => $proyecto->pro_id, 'id' => $proyecto->pro_id])}}" method="post">

                      <input type="hidden" value="planta" name="desde">
                      <input type="hidden" value="{{$proyecto->pro_id}}" name="idproyecto">
                      <input type="hidden" value="{{$planta->flo_id}}" name="idplanta">

                      {{ csrf_field() }}

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="descripcion">Descripción</label>
                          <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="nombre">Nombre</label>
                          <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="documento">Documento</label>
                          <input type="file" name="documento" id="file-subirdocplanta-{{$planta->flo_id}}" class="file form-control">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="nombre">Seleccionar Categoría</label>
                          <select class="form-control" name="categoria" id="categoria">
                            <option value="">Seleccione una categoria</option>
                            @foreach($categorias as $categoria)
                            <?php 
                            $cadena= $categoria->doc_metadata;
                            $borrar= array('{"estructura": ["','"]}');
                            $cadena = str_replace($borrar, '',$cadena);
                            $cambiar = array('","');
                            $cadena = str_replace($cambiar, '->', $cadena);   ?>

                            <option value="{{$categoria->doc_metadata}}">{{$cadena}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>





                      <div class="col-md-4">
                        <div class="form-group">
                          <p>O Cree una categoria Nueva</p>
                          <label for="nombre">Seleccionar Categoría padre</label>
                          <select class="form-control" name="categoria_padre" id="categoria_padre">
                            <option value="Sin Categoria">Sin Categoria Padre</option>
                            @foreach($categorias as $categoria)
                            <?php 
                            $cadena= $categoria->doc_metadata;
                            $borrar= array('{"estructura": ["','"]}');
                            $cadena = str_replace($borrar, '',$cadena);
                            $cambiar = array('","');
                            $cadena = str_replace($cambiar, '->', $cadena);   ?>

                            <option value="{{$categoria->doc_metadata}}">{{$cadena}}</option>
                            @endforeach
                          </select>
                          <label for="nombre">Nueva Categoria</label>
                          <input type="text" name="nueva_categoria" id="nueva_categoria" placeholder="nueva_categoria" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <button type="submit" id="upload_btn" class="btn btn-primary">Subir documento al proyecto</button>
                        </div>
                      </div>
                    </form>
                    <br><br>

                  </div>  



                  <h3 class="box-title paddingleft0">Unidades de {{$planta->flo_name}}</h3>

                  @if (Session::has('pisonuevo'))
                  <div class="alert alert-success alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 20px; margin-bottom: 20px">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('pisonuevo') }}.
                  </div>

                  <div style="clear: both;"></div>
                  @endif

                  <div class="col-md-12 paddingleft0">
                    <form role="form" enctype="multipart/form-data" action="{{route('proyecto.crearpiso',['proy' => $proyecto->pro_id, 'id'=>$planta->flo_id])}}" method="post">

                      {{ csrf_field() }}


                      <div class="col-md-4">
                        <div class="form-group">

                          <input type="text" name="nombrepiso" placeholder="Nombre de la Unidad" id="nombrepiso" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4 paddingleft0">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Crear Unidad</button>
                        </div>
                      </div>
                    </form>
                  </div>




                  @foreach($pisos as $piso)
                  @if($piso->sec_flo_id == $planta->flo_id)

                  <div class="col-md-12">

                    @if (Session::has('salanueva'))
                    @if (Session::get('piso')==$piso->sec_id)
                    <div id="piso-{{$piso->sec_id}}" class="box box-warning box-solid">
                      @else
                      <div id="piso-{{$piso->sec_id}}" class="box box-warning box-solid collapsed-box">
                        @endif
                        @else 
                        <div id="piso-{{$piso->sec_id}}" class="box box-warning box-solid collapsed-box">
                          @endif

                          @if (Session::has('pisonuevo'))
                          @if(Session::get('idpisonuevo')==$piso->sec_id)
                          <div class="box-header with-border" style="background: olivedrab"  data-widget="collapse">
                            @else
                            <div class="box-header with-border" data-widget="collapse">
                              @endif
                              @else
                              <div class="box-header with-border" data-widget="collapse">
                                @endif

                                <h3 class="box-title">{{$piso->sec_name}}</h3>
                                @if (Session::has('pisonuevo'))
                                @if(Session::get('idpisonuevo')==$piso->sec_id)
                                ({{Session::get('mensaje')}})
                                @endif
                                @endif

                                <div class="box-tools pull-right">
                                  <!-- Collapse Button -->
                                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                  </button>
                                </div>
                                <!-- /.box-tools -->
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">    

                                <div class="row">
                                  <div class="" style="float: left; padding-right: 15px">
                                    <a href="{{route('copiarPiso',['proy' => $proyecto->pro_id, 'id' => $piso->sec_id])}}" class="margingleft15 btn btn-primary">Duplicar {{$piso->sec_name}} </a>
                                  </div>
                                  <div class="" style="float: left; padding-right: 15px">
                                    <a href="{{route('eliminarpiso',['proy' => $proyecto->pro_id, 'id' => $piso->sec_id])}}" class="btn btn-danger">Eliminar {{$piso->sec_name}} </a>
                                  </div>
                                  <div class="" style="float: left; padding-right: 15px; width: 300px">
                                    <form role="form" enctype="multipart/form-data" action="{{route('editarpiso',['proy' => $proyecto->pro_id, 'id'=>$piso->sec_id])}}" method="post">
                                      {{ csrf_field() }}

                             
                                      <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ingrese nombre" name="nombrepiso" value="{{$piso->sec_name}}">
                                        <span class="input-group-btn">
                                           <button type="submit" class="btn btn-primary">Editar Unidad</button>
                                        </span>
                                      </div><!-- /input-group -->
                                    </form>
                                  </div>
                                  <div style="clear: both;"></div>
                                  <h3 class="paddingleft15">Documentos de {{$piso->sec_name}}</h3>
                                  <div class="paddingleft15">

                                    <ul class="nav nav-tabs">
                                      <?php 
                                      $a=1;
                                      foreach ($life as $key) {
                                        if($key['count']==1){
                                          ?>
                                          <li <?php if($a==1){echo 'class="active"';} ?>><a data-toggle='tab' href='#piso-{{$piso->sec_id}}-<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></a></li>
                                          <?php }
                                          $a=$a+1;
                                        } ?>
                                      </ul>


                                      <div class="tab-content">

                                        <?php 
                                        $b=1;
                                        foreach ($life as $key) {
                                          if($key['count']==1){



                                            ?>
                                            <div id='piso-{{$piso->sec_id}}-<?php echo $key['id'] ?>' class="tab-pane fade in <?php if($b==1){echo 'active';} ?>">

                                              <?php 
                                              $i=0;
                                              foreach ($life as $key2) {
                                                if($key['meta']==$key2['idpadre']){
                                                  $i=$i+1;
                                                }
                                              }
                                              ?>

                                              <?php 
                                              if($i>0){

                                                recorrerpiso($key['meta'], $life, $documentos, $piso);

                                              } ?>


                                              <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>

                                              <?php 
                                              $apiso=0;
                                              ?>
                                              @foreach($documentos as $documento)
                                              @if($documento->doc_sec_id==$piso->sec_id && $documento->doc_metadata==$key['meta'])
                                              <div class="col-md-3 col-sm-6 col-xs-12">
                                                <a href="{{ $documento->doc_file_path }}">
                                                  <div class="info-box">
                                                    <span class="info-box-icon  bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>

                                                    <div class="info-box-content">
                                                      <span class="info-box-number">{{ $documento->doc_name }}</span>

                                                    </div>
                                                    <!-- /.info-box-content -->
                                                  </div>
                                                </a>
                                                <!-- /.info-box -->
                                              </div>
                                              <?php 
                                              $apiso=$apiso+1;
                                              ?>
                                              @endif

                                              @endforeach

                                              <?php 
                                              if($apiso==0){
                                                echo "<h3>No hay archivos para esta categoria.</h3>";
                                              }
                                              ?>



                                            </div>
                                            <?php }
                                            $b=$b+1;} ?>

                                          </div>
                                        </div>



                                        <div class="col-md-12 col-sm-12 col-xs-12 success-piso-{{$piso->sec_id}}">
                                        </div>

                                        <form name="subirdocpiso-{{$piso->sec_id}}" role="form" class="target" enctype="multipart/form-data" action="{{route('documento.agregarproy',['proy' => $proyecto->pro_id, 'id' => $proyecto->pro_id])}}" method="post">

                                          <input type="hidden" value="piso" name="desde">
                                          <input type="hidden" value="{{$proyecto->pro_id}}" name="idproyecto">
                                          <input type="hidden" value="{{$piso->sec_id}}" name="idpiso">

                                          {{ csrf_field() }}

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label for="descripcion">Descripción</label>
                                              <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" class="form-control">
                                            </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label for="nombre">Nombre</label>
                                              <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control">
                                            </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label for="documento">Documento</label>
                                              <input type="file" name="documento" id="file-subirdocpiso-{{$piso->sec_id}}" class="file form-control">
                                            </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label for="nombre">Seleccionar Categoría</label>
                                              <select class="form-control" name="categoria" id="categoria">
                                                <option value="">Seleccione una categoria</option>
                                                @foreach($categorias as $categoria)
                                                <?php 
                                                $cadena= $categoria->doc_metadata;
                                                $borrar= array('{"estructura": ["','"]}');
                                                $cadena = str_replace($borrar, '',$cadena);
                                                $cambiar = array('","');
                                                $cadena = str_replace($cambiar, '->', $cadena);   ?>

                                                <option value="{{$categoria->doc_metadata}}">{{$cadena}}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>





                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <p>O Cree una categoria Nueva</p>
                                              <label for="nombre">Seleccionar Categoría padre</label>
                                              <select class="form-control" name="categoria_padre" id="categoria_padre">
                                                <option value="Sin Categoria">Sin Categoria Padre</option>
                                                @foreach($categorias as $categoria)
                                                <?php 
                                                $cadena= $categoria->doc_metadata;
                                                $borrar= array('{"estructura": ["','"]}');
                                                $cadena = str_replace($borrar, '',$cadena);
                                                $cambiar = array('","');
                                                $cadena = str_replace($cambiar, '->', $cadena);   ?>

                                                <option value="{{$categoria->doc_metadata}}">{{$cadena}}</option>
                                                @endforeach
                                              </select>
                                              <label for="nombre">Nuevo Recinto</label>
                                              <input type="text" name="nueva_categoria" id="nueva_categoria" placeholder="nueva_categoria" class="form-control">
                                            </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <button type="submit" id="upload_btn" class="btn btn-primary">Subir documento al Recinto</button>
                                            </div>
                                          </div>
                                        </form>
                                        <br><br>
                                      </div>  

                                      <div class="col-md-12 paddingleft0">
                                        <form role="form" enctype="multipart/form-data" action="{{route('proyecto.crearsala',['proy' => $proyecto->pro_id, 'id'=>$piso->sec_id])}}" method="post">

                                          {{ csrf_field() }}

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="nombresala">Nombre del Recinto</label>
                                              <input type="text" name="nombresala" placeholder="Nombre de la Unidad" id="nombresala" class="form-control">
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <button type="submit" class="btn btn-primary">Crear Recinto</button>
                                            </div>
                                          </div>
                                        </form>
                                      </div>

                                      <h3 class="paddingleft15">Recintos de {{$piso->sec_name}}</h3>

                                      @foreach($salas as $sala)
                                      @if($sala->fac_sec_id == $piso->sec_id)

                                      <div class="col-md-12">
                                        <div class="box box-warning box-solid collapsed-box">

                                          @if (Session::has('salanueva'))
                                          @if(Session::get('idsala')==$sala->fac_id)
                                          <div class="box-header with-border" style="background: olivedrab"  data-widget="collapse">
                                            @else
                                            <div class="box-header with-border" data-widget="collapse">
                                              @endif
                                              @else
                                              <div class="box-header with-border" data-widget="collapse">
                                                @endif



                                                <h3 class="box-title">{{$sala->fac_name}}</h3>
                                                @if (Session::has('salanueva'))
                                                @if(Session::get('idsala')==$sala->fac_id)
                                                ({{Session::get('mensaje')}})
                                                @endif
                                                @endif
                                                <div class="box-tools pull-right">
                                                  <!-- Collapse Button -->
                                                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                    <i class="fa fa-minus"></i>
                                                  </button>
                                                </div>
                                                <!-- /.box-tools -->
                                              </div>
                                              <!-- /.box-header -->
                                              <div class="box-body">
                                                <div class="row">
                                                  <div class="" style="float: left; padding-right: 15px">
                                                  <a href="{{route('copiarSala',['proy' => $proyecto->pro_id, 'id' => $sala->fac_id])}}" class="margingleft15 btn btn-primary">Duplicar {{$sala->fac_name}} </a>
                                                </div>

                                                <div class="" style="float: left; padding-right: 15px">  
                                                  <a href="{{route('eliminarpiso',['proy' => $proyecto->pro_id, 'id' => $sala->fac_id])}}" class="btn btn-danger">Eliminar {{$sala->fac_name}} </a>
                                                </div>
                                                  <div class="" style="float: left; padding-right: 15px; width: 300px">
                                                  
                                                       <form role="form" enctype="multipart/form-data" action="{{route('editarsala',['proy' => $proyecto->pro_id, 'id'=>$sala->fac_id])}}" method="post">
                                      {{ csrf_field() }}

                             
                                      <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ingrese nombre" name="nombresala" value="{{$sala->fac_name}}">
                                        <span class="input-group-btn">
                                           <button type="submit" class="btn btn-primary">Editar Recinto</button>
                                        </span>
                                      </div><!-- /input-group -->
                                    </form>

                                                  </div>
                                                  <div style="clear: both;"></div>


                                                  <h1>Archivos de {{$sala->fac_name}}</h1>

                                                  <div class="paddingleft15"> 

                                                    <ul class="nav nav-tabs">
                                                      <?php 
                                                      $a=1;
                                                      foreach ($life as $key) {
                                                        if($key['count']==1){
                                                          ?>
                                                          <li <?php if($a==1){echo 'class="active"';} ?>><a data-toggle='tab' href='#seccion-{{$sala->fac_id}}-<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></a></li>
                                                          <?php }
                                                          $a=$a+1;
                                                        } ?>
                                                      </ul>


                                                      <div class="tab-content">

                                                        <?php 
                                                        $b=1;
                                                        foreach ($life as $key) {
                                                          if($key['count']==1){



                                                            ?>
                                                            <div id='seccion-{{$sala->fac_id}}-<?php echo $key['id'] ?>' class="tab-pane fade in <?php if($b==1){echo 'active';} ?>">

                                                              <?php 
                                                              $i=0;
                                                              foreach ($life as $key2) {
                                                                if($key['meta']==$key2['idpadre']){
                                                                  $i=$i+1;
                                                                }
                                                              }
                                                              ?>

                                                              <?php 
                                                              if($i>0){

                                                                recorrerseccion($key['meta'], $life, $documentos, $sala);

                                                              } ?>

                                                              <h3 style="clear: both;">Archivos de {{$key['nombre']}}</h3>

                                                              <?php 
                                                              $aseccions=0;
                                                              ?>
                                                              @foreach($documentos as $documento)
                                                              @if($documento->doc_sec_id==$sala->fac_id && $documento->doc_metadata==$key['meta'])
                                                              <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <a href="{{ $documento->doc_file_path }}">
                                                                  <div class="info-box">
                                                                    <span class="info-box-icon  bg-yellow"><i class="fa fa-files-o fa-lg"></i></span>

                                                                    <div class="info-box-content">
                                                                      <span class="info-box-number">{{ $documento->doc_name }}</span>

                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                  </div>
                                                                </a>
                                                                <!-- /.info-box -->
                                                              </div>
                                                              <?php 
                                                              $aseccions=$aseccions+1;
                                                              ?>
                                                              @endif

                                                              @endforeach

                                                              <?php 
                                                              if($aseccions==0){
                                                                echo "<h3>No hay archivos para esta categoria.</h3>";
                                                              }
                                                              ?>



                                                            </div>
                                                            <?php }
                                                            $b=$b+1;} ?>

                                                          </div>
                                                        </div>


                                                        <div class="col-md-12 col-sm-12 col-xs-12 success-sala-{{$sala->fac_id}}">
                                                        </div>

                                                        <form name="subirdocsala-{{$sala->fac_id}}" role="form" class="target" enctype="multipart/form-data" action="{{route('documento.agregarproy',['proy' => $proyecto->pro_id, 'id' => $proyecto->pro_id])}}" method="post">

                                                          <input type="hidden" value="sala" name="desde">
                                                          <input type="hidden" value="{{$proyecto->pro_id}}" name="idproyecto">
                                                          <input type="hidden" value="{{$sala->fac_id}}" name="idsala">

                                                          {{ csrf_field() }}

                                                          <div class="col-md-4">
                                                            <div class="form-group">
                                                              <label for="descripcion">Descripción</label>
                                                              <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" class="form-control">
                                                            </div>
                                                          </div>

                                                          <div class="col-md-4">
                                                            <div class="form-group">
                                                              <label for="nombre">Nombre</label>
                                                              <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control">
                                                            </div>
                                                          </div>

                                                          <div class="col-md-4">
                                                            <div class="form-group">
                                                              <label for="documento">Documento</label>
                                                              <input type="file" name="documento" id="file-subirdocsala-{{$sala->fac_id}}" class="file form-control">
                                                            </div>
                                                          </div>

                                                          <div class="col-md-4">
                                                            <div class="form-group">
                                                              <label for="nombre">Seleccionar Categoría</label>
                                                              <select class="form-control" name="categoria" id="categoria">
                                                                <option value="">Seleccione una categoria</option>
                                                                @foreach($categorias as $categoria)
                                                                <?php 
                                                                $cadena= $categoria->doc_metadata;
                                                                $borrar= array('{"estructura": ["','"]}');
                                                                $cadena = str_replace($borrar, '',$cadena);
                                                                $cambiar = array('","');
                                                                $cadena = str_replace($cambiar, '->', $cadena);   ?>

                                                                <option value="{{$categoria->doc_metadata}}">{{$cadena}}</option>
                                                                @endforeach
                                                              </select>
                                                            </div>
                                                          </div>





                                                          <div class="col-md-4">
                                                            <div class="form-group">
                                                              <p>O Cree una categoria Nueva</p>
                                                              <label for="nombre">Seleccionar Categoría padre</label>
                                                              <select class="form-control" name="categoria_padre" id="categoria_padre">
                                                                <option value="Sin Categoria">Sin Categoria Padre</option>
                                                                @foreach($categorias as $categoria)
                                                                <?php 
                                                                $cadena= $categoria->doc_metadata;
                                                                $borrar= array('{"estructura": ["','"]}');
                                                                $cadena = str_replace($borrar, '',$cadena);
                                                                $cambiar = array('","');
                                                                $cadena = str_replace($cambiar, '->', $cadena);   ?>

                                                                <option value="{{$categoria->doc_metadata}}">{{$cadena}}</option>
                                                                @endforeach
                                                              </select>
                                                              <label for="nombre">Nueva Categoria</label>
                                                              <input type="text" name="nueva_categoria" id="nueva_categoria" placeholder="nueva_categoria" class="form-control">
                                                            </div>
                                                          </div>

                                                          <div class="col-md-4">
                                                            <div class="form-group">
                                                              <button type="submit" id="upload_btn" class="btn btn-primary">Subir documento a la sala</button>
                                                            </div>
                                                          </div>
                                                        </form>
                                                        <br><br>

                                                        <br><br>

                                                      </div>  

                                                      <div class="row">
                                                        @foreach($documentos as $documento)
                                                        @if($documento->doc_fac_id==$sala->fac_id)
                                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                                          <a href="{{ $documento->doc_file_path }}">
                                                            <div class="info-box">
                                                              <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

                                                              <div class="info-box-content">
                                                                <span class="info-box-number">{{ $documento->doc_name }}</span>
                                                                <span class="info-box-text">{{ $documento->doc_text }}</span>              
                                                                <p> {{ $documento->doc_date }} </p>
                                                              </div>
                                                              <!-- /.info-box-content -->
                                                            </div>
                                                          </a>
                                                          <!-- /.info-box -->
                                                        </div>
                                                        @endif
                                                        @endforeach
                                                      </div>


                                                    </div>
                                                    <!-- /.box-body -->

                                                  </div>
                                                  <!-- /.box -->
                                                </div>
                                                @endif

                                                @endforeach
                                              </div>
                                              <!-- /.box-body -->

                                            </div>
                                            <!-- /.box -->
                                          </div>
                                          @endif

                                          @endforeach
                                        </div>
                                        <!-- /.box-body -->

                                      </div>
                                      <!-- /.box -->
                                    </div>
                                    @endforeach
                                  </div>
                                  <!-- /.box-body -->

                                </div>
                                <!-- /.box -->
                              </div>

                            </div>

                          </section>

                          @endsection
