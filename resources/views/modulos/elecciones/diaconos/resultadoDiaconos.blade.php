@extends('layout.master')

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
                        <div class="col-md-12 col-sm-12 col-xs-12" id="divSerial" style="height: 400px; width: 100%;">
                        </div>
                    </div>
                    <br>
                    <hr>
                    <h3>Resultados Totales</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-12" id="divTabla">
                            {!! $tablaTotales !!}
                        </div>
                        <hr>
                        <div class="col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-12" id="divTabla">
                            <h3 style="text-align: center;" id="totalVotos">TOTAL VOTOS: {{$collTotal}}</h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('vendors/amcharts/amcharts.js') !!}
    {!! HTML::script('vendors/amcharts/pie.js') !!}
    {!! HTML::script('vendors/amcharts/serial.js') !!}
    {!! HTML::script('vendors/amcharts/themes/light.js') !!}
    {!! HTML::script('vendors/amcharts/themes/dark.js') !!}
    <script type="text/javascript">
        $(document).ready(function () {
            var datos = JSON.parse('{!! $top5txt !!}');
            dibujarGrafica(datos);

            setInterval(function()
            {
                realTime();
            }, 10000);
        });

        function realTime() {
            $.ajax({
                url: 'real-time',
                success: function (response) {
                    var res = JSON.parse(response);

                    dibujarGrafica(res.grafica);
                    $('#divTabla').html(res.tabla);
                    $('#totalVotos').html('TOTAL VOTOS: '+res.total);
                } // FIN SUCCESS
            }); // FIN AJAX
        }


        function dibujarGrafica(datos) {
            var chart = AmCharts.makeChart("divSerial", {
                "type": "serial",
                "theme": "light",
                "marginRight": 70,
                "dataProvider": datos,
                "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left",
                    "title": "Votos"
                }],
                "startDuration": 1,
                "graphs": [{
                    "balloonText": "<b>[[category]]: [[value]]</b>",
                    "fillColorsField": "color",
                    "fillAlphas": 1,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "votos",
                    "labelText": "[[value]]",
                    "labelPosition": "top"
                }],
                "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                },
                "categoryField": "nombre",
                "categoryAxis": {
                    "gridPosition": "start",
                    "labelRotation": 0
                },
                "export": {
                    "enabled": true
                }

            });
        }

    </script>
@stop






