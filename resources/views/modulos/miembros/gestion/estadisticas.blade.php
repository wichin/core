@extends('layout.master')
@section('css')
    <style>
        th
        {
            text-align: center;
        }
    </style>
@stop
@section('contenido')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{$titulo}}<small>{{$subtitulo}}</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="echart-grupo" style="height: 500px;"></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="echart-sexo" style="height: 500px;"></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="echart-evento"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            var array_grupo = '{!! $chartGrupo !!}';
            var array_sexo  = '{!! $chartSexo !!}';
            var array_evento = '{!! $chartEvento !!}'

            var grupo = JSON.parse(array_grupo);
            var sexo = JSON.parse(array_sexo);
            var evento  = JSON.parse(array_evento);

            var alto = evento[0].length*100+50;
            $('#echart-evento').css('height',alto);

            echarPie('echart-grupo',grupo,'Grupos de Miembros');
            echarPie('echart-sexo',sexo,'Miembros por género');
            echarHorizontalBar('echart-evento',evento,'Eventos de miembros');
        });
    </script>

    {!! Html::script('js/modulos/miembros/gestion/estadisticas.js') !!}
@stop