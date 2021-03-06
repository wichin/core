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
                                <form action="{{url('/procesos/modulos/listar')}}" method="POST" id="frmModulo">
                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="proceso">Proceso</label>
                                                <select class="form-control" name="proceso" id="proceso" style="width: 100%">
                                                    <option value=""></option>
                                                    @if(isset($procesos)&&count($procesos))
                                                        @foreach($procesos as $item)
                                                            <option value="{{$item->id}}" {{isset($_REQUEST['proceso'])&&$_REQUEST['proceso']==$item->id?'selected':''}}>
                                                                {{$item->nombre}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <select class="form-control" name="estado" id="estado" style="width: 100%">
                                                    <option value=""></option>
                                                    @if(isset($estadoMod)&&count($estadoMod))
                                                        @foreach($estadoMod as $item)
                                                            <option value="{{$item->id}}" {{isset($_REQUEST['estado'])&&$_REQUEST['estado']==$item->id?'selected':''}}>
                                                                {{$item->descripcion}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-xs-12 col-md-offset-3 col-sm-offset-0 col-xs-offset-0">
                                            <button type="submit" class="btn btn-success col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px;">
                                                <i class="fa fa-search fa-lg"></i> &nbsp;BUSCAR
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    @if(isset($html))
                        <hr>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                {!! $html !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="mdlFinalizar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="frmFinalizar">
                    <input type="hidden" id="dataF">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">
                            <i class="fa fa-check-square fa-lg"></i> &nbsp;Finalizar Módulo Educativo
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-8 col-xs-12 col-md-offset-3 col-sm-offset-2 col-xs-offset-0">
                                <div class="form-group">
                                    <label for="fecha">Fecha finalización</label>
                                    <input type="text" class="form-control" id="fecha" name="fecha" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnFinalizar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="mdlInstructores">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('agregarInstructores')}}" method="POST" id="frmInstructores">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_dataI" id="_dataI">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            <i class="fa fa-user fa-lg"></i> &nbsp;<span id="ttlInstructores"></span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="instructores">Seleccionar instructores</label>
                                    <select class="form-control" name="instructores[]" id="instructores" style="width: 100%;" multiple required>

                                    </select>
                                </div>
                                <div id="error-instructor"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnInstructores">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('js/modulos/procesos/modulos/listarmodulo.js') !!}
@stop