@extends('layout.master')
@section('css')
    <style>
        .panel:hover
        {
            background: white !important;
        }
        .x_panel
        {
            border: black solid 2px !important;
        }

        label, .x_title
        {
            color: black !important;
        }

        .form-control
        {
            border: black solid 1px !important;
        }
    </style>
@stop
@section('contenido')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Registrar avances</h2>
                    <!-- <h2>{{$titulo}}<small>{{$subtitulo}}</small></h2> -->
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="modulo">Porcentaje de avances</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="modulo">Resultado de curso</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3 col-sm-offset-3">
                            <button class="btn btn-primary col-sm-12" style="margin-top: 24px;">ACTUALIZAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div hidden>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="">Observaciones</label>
                <textarea class="form-control" name="" id="" cols="30" rows="2"></textarea>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="modulo">Seleccione evento</label>
                <select name="" id="" class="form-control">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="modulo">Seleccione proceso</label>
                <select name="" id="" class="form-control">
                    <option value=""></option>
                </select>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="modulo">Ingrese fecha</label>
                <input type="text" class="form-control">
            </div>
        </div>
    </div>

@stop

@section('js')
    {!! Html::script('js/modulos/administracion/sistema/modulo.js') !!}
    <script>
        $(document).ready(function () {
        });
    </script>
@stop