<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->user_email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i>En Linea</a>
                </div>
            </div>
        @endif
        <ul class="sidebar-menu">
            <li class="active"><a href="{{route('proyectos.index')}}"><i class='fa fa-link'></i> <span>Proyectos</span></a></li>
            <li class="active"><a href="{{route('usuarios.index')}}"><i class='fa fa-link'></i> <span>Usuarios</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
