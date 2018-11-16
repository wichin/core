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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="echart-alumnos"></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="echart-procesos" style="height: 500px;"></div>
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
            var array_alumnos = '{!! $chartAlumno !!}';
            var array_modulos = '{!! $chartModulo !!}';

            var alumnos = JSON.parse(array_alumnos);
            var modulos = JSON.parse(array_modulos);

            var alto = alumnos[0].length*100+50;
            $('#echart-alumnos').css('height',alto);

            echarHorizontalBar('echart-alumnos',alumnos,'Alumnos por Proceso');
            echarPie('echart-procesos',modulos,'Modulos educativos por Proceso');
        });
    </script>

    {!! Html::script('js/modulos/procesos/modulos/estadisticas.js') !!}
@stop