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
    <div class="container body">
        <a href="{!! url('/logout') !!}">
            Cerrar Sesi&oacute;n
        </a>
    </div>
</body>
</html>

@include('layout.script')
@section('js')
@show