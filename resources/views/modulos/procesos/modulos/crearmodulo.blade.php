@extends('layout.master')
@section('css')
    <style>
        .panel:hover
        {
            background: white !important;
        }
        th
        {
            text-align: center;
        }

        textarea
        {
            resize: vertical;
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
                    <form action="{{url('/procesos/modulos/crear')}}" method="POST" id="frmModulo">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" maxlength="500" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="tipo">Tipo reunión</label>
                                    <select class="form-control" name="tipo" id="tipo" required>
                                        @if(isset($catTipo)&&count($catTipo)>0)
                                            <option value="" style="display: none;" selected>Seleccione...</option>
                                            @foreach($catTipo as $item)
                                                <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="proceso">Proceso</label>
                                    <select class="form-control" name="proceso" id="proceso" required>
                                        @if(isset($procesos)&&count($procesos)>0)
                                            <option value="" style="display: none;" selected>Seleccione...</option>
                                            @foreach($procesos as $item)
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="inicio">Inicio</label>
                                    <input type="text" class="form-control" id="inicio" name="inicio" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="final">Finalizacion</label>
                                    <input type="text" class="form-control" id="final" name="final" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-md-offset-5 col-sm-offset-0 col-xs-offset-0">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12" style="margin-top: 24px;">GUARDAR</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('js/modulos/procesos/modulos/crearmodulo.js') !!}
@stop