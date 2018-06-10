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
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 col-xs-offset-0">
                            @if(isset($dataDigitadores)&&count($dataDigitadores)>0)
                                <table class="table table-striped">
                                    <thead>
                                    <th>Digitador</th>
                                    <th>Votantes Registrados</th>
                                    </thead>
                                    <tbody>
                                    @foreach($dataDigitadores as $dd)
                                        <tr>
                                            <td>{{$dd->nombre.' '.$dd->apellido}}</td>
                                            <td>{{$dd->conteo}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <h3>Total de Votos: {{$collTotal}}</h3>
                            @else
                                <h3 style="text-align: center;">NO EXISTEN REGISTROS PARA MOSTRAR</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop