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
                    {!!  isset($htmlUsuario)?$htmlUsuario:'' !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
        })
    </script>
@stop