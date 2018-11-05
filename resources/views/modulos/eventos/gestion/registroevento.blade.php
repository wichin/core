@extends('layout.master')
@section('css')
    {!! Html::style('vendors/autocomplete/content/styles.css') !!}
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
                    <form action="{{url('/evento/gestion/registro')}}" method="POST" id="frmUsuario">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-8 col-sm-7 col-xs-12">
                                <div class="form-group">
                                    <label for="persona">Ingrese nombres para búsqueda</label>
                                    <input type="text" class="form-control" id="persona" name="persona" required>
                                    <input type="hidden" id="idPersona" name="idPersona">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="evento">Evento</label>
                                    <select class="form-control" name="evento" id="evento" required>
                                        <option value="" style="display: none;" selected>Seleccione...</option>
                                        @if(isset($listEvento)&&count($listEvento)>0)
                                            @foreach($listEvento as $item)
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
                                    <textarea class="form-control" name="observaciones" id="observaciones" rows="3" maxlength="3000"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="text" class="form-control" id="fecha" name="fecha" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-5 col-xs-12 col-md-offset-6 col-sm-offset-3 col-xs-offset-0">
                                <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12" style="margin-top: 24px;">
                                    GUARDAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('vendors/autocomplete/src/jquery.autocomplete.js') !!}
    {!! Html::script('js/modulos/eventos/gestion/registroevento.js') !!}
@stop