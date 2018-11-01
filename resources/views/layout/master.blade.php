<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="language" content="en"/>
    <meta name="token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{!! asset('images/favicon.ico')!!}" type="image/x-icon">
    <link rel="icon" href="{!! asset('images/favicon.ico')!!}" type="image/x-icon">

    <title>
        SMIRNA | {!! $tituloPagina !!}
    </title>

    @include('layout.style')
    @section('css')
    @show
</head>
<body class="nav-md" >
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="margin-bottom: 40px;">
                    <div class="row" >
                        <div class="col-md-8 col-md-offset-2">
                            <br>
                            <img src="{!! asset('images/logo_blanco.png') !!}" alt="..." class="img-responsive">

                        </div>
                    </div>
                </div>

                <!-- menu profile quick info -->
                <div class="profile" style="margin-bottom: 200px;">
                    <div class="profile_pic">
                        @if(isset(Session::get('usuario')['foto']))
                            <img src="{{ Session::get('usuario')['foto'] }}" alt="..." class="img-circle profile_img">
                        @else
                            <img src="{!! asset('images/silueta.png') !!}" alt="..." class="img-circle profile_img">
                        @endif

                    </div>
                    <div class="profile_info">
                        <span>Bienvenido</span>
                        <h2>{!! $usuario['nombres'] !!}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <!-- sidebar menu -->

                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li><a href="{{url('inicio')}}"><i class="fa fa-home"></i> Inicio</a>
                            </li>
                        </ul>
                        @if(isset(Session::get('usuario')['menus']))
                            <ul class="nav side-menu">
                                @foreach(Session::get('usuario')['menus'] as $mod)
                                    <li><a><i style="color:#1ABB9C;" class="{{$mod[0]->icono}}"></i>{{$mod[0]->nom_mod}}<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                        @foreach(collect($mod)->groupBy('id_men') as $men)
                                            <li><a>{{$men[0]->nom_men}}</a>
                                                <ul class="nav child_menu">
                                                @foreach($men as $app)
                                                    <li><a href="{{asset($app->url)}}">{{$app->nom_app}}</a></li>
                                                @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </li>
                                @endforeach

                            </ul>
                        @endif

                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a href="{{url('/inicio')}}" data-toggle="tooltip" data-placement="top" title="Inicio">
                        <span class="fa fa-home fa-lg" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a href="{!! url('/logout') !!}" data-toggle="tooltip" data-placement="top" title="Cerrar Sesión">
                        <i class="fa fa-power-off fa-lg"></i>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                @if(isset(Session::get('usuario')['foto']))
                                    <img src="{{ Session::get('usuario')['foto'] }}" alt="...">
                                @else
                                    <img src="{!! asset('images/silueta.png') !!}" alt="...">
                                @endif
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
        <!-- top navigation -->

        <!-- page content-->
        <div class="right_col" role="main">
            @section('contenido')
            @show
        </div>
        <!-- page content-->
    </div>
</div>

@include('layout.script')
<script>
    $(document).ready(function () {
                @if(Session::has('mensaje'))
        var notice = new PNotify({
                title: '{{Session::get('mensaje')['titulo']}}',
                text: '{{Session::get('mensaje')['msg']}}',
                type: '{{Session::get('mensaje')['class']}}',
                icon: false
            });
        notice.get().click(function() {
            notice.remove();
        });
        @endif
    });

</script>
@section('js')
@show
</body>
</html>

