<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="language" content="en"/>

    <link rel="shortcut icon" href="{!! asset('images/favicon.ico')!!}" type="image/x-icon">
    <link rel="icon" href="{!! asset('images/favicon.ico')!!}" type="image/x-icon">

    <title>
        Iglesia Smirna | {!! $tituloPagina !!}
    </title>

    <style>
        .formulario {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }
    </style>

    @section('css')
        @include('layout.style')
    @show
</head>

<body class="nav-md" >
    <br><br><br>
    <div class="container body">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 well">
            @if (Session::has('mensaje'))
                <div class="alert {!! $info['class'] !!} alert-dismissible" role="alert" style="text-align: center">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{!! $info['titulo'] !!}</strong><br>{!! $info['msg'] !!}<br>
                </div>
            @endif

            <div class="col-md-6 col-sm-6 col-xs-12">
                <br><br>
                {!! Html::image('images/logo_azul.png', 'logo', array('class' => 'img-responsive')) !!}
                <br><br>
            </div>
            <form action="{!! url('/login') !!}" method="POST">
                <div class="col-md-6 col-sm-6 col-xs-12" style="color: #003366;">
                    <h4>Iniciar Sesi&oacute;n</h4>
                    <hr>
                    <div class="form-group">
                        <label for="nombre">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="clave" name="clave" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-success col-md-12 col-sm-12 col-xs-12">Aceptar</button>
                    </div>
                </div>
                <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">
            </form>
        </div>
    </div>
</body>
</html>

@include('layout.script')
@section('js')
@show