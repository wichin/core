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
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <form action="{{url('/procesos/modulos/crear')}}" method="POST" id="frmModulo">
                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="form-group">
                                                <label for="proceso">Proceso</label>
                                                <select class="form-control" name="proceso" id="proceso">
                                                    <option value=""></option>
                                                    @if(isset($procesos)&&count($procesos))
                                                        @foreach($procesos as $item)
                                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <select class="form-control" name="estado" id="estado">
                                                    <option value=""></option>
                                                    @if(isset($estadoMod)&&count($estadoMod))
                                                        @foreach($estadoMod as $item)
                                                            <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('js/modulos/procesos/modulos/listarmodulo.js') !!}
@stop