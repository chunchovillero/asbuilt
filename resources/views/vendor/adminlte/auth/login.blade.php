@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')


<body class="hold-transition login-page">
    <div class="container" id="contenedor-login">
        <div id="header-login">
            <figure><img class="center-block img-responsive" src="img/logo-login.png" alt="Logo"></figure>
        </div>
        <div id="contenido-login">
            <h3>Ingresar credenciales</h3>
            <form action="{{ url(config('adminlte.login_url', 'login')) }}" id="form-login" method="post">
                <div class="form-group">
                    {!! csrf_field() !!}
                   

                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" id="user" class="form-control user-textfield textfield" value="{{ old('email') }}"
                           placeholder="Ingrese su email">

              
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>


                 <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" id="pass" class="form-control password-textfield textfield"
                           placeholder="Ingrese su contraseña">
                    
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                </div>
                
                <button  id="login_btn" class="boton-principal">Ingresar</button>
            </form>
          
        </div>
    </div>
    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
