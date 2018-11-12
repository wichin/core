@extends('layout.master')
@section('css')
    {!! Html::style('vendors/autocomplete/content/styles.css') !!}
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
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-success btn-sm" id="btnNewElement">
                                <i class="fa fa-users"></i> &nbsp;NUEVO ALUMNO
                            </button>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="well">
                                <form action="{{url('/procesos/modulos/alumnos')}}" method="POST" id="frmBuscarAlumnos">
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
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="modulo">Modulo Educativo</label>
                                                <select class="form-control" name="modulo" id="modulo" style="width: 100%" required>
                                                    @if(isset($moduloFind)&&count($moduloFind)>0)
                                                        <option value=""></option>
                                                        @foreach($moduloFind as $item)
                                                            <option value="{{$item->id}}" {{isset($_REQUEST['modulo'])&&$_REQUEST['modulo']==$item->id?'selected':''}}>{{$item->nombre}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-xs-12">
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

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="mdlNuevoAlumno">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('/procesos/modulos/agregarAlumno')}}" method="POST" id="frmNuevoAlumno">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">
                            <i class="fa fa-users fa-lg"></i> &nbsp;Nuevo alumno
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="newModulo">Modulo Educativo</label>
                                    <select class="form-control" name="newModulo" id="newModulo" required>
                                        @if(isset($catModulo)&&count($catModulo)>0)
                                            <option value="" style="display: none;" selected>Seleccione...</option>
                                            @foreach($catModulo as $item)
                                                <option value="{{$item->id}}">{{$item->Proceso->nombre.' - '.$item->nombre}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="newPersona">Ingrese nombres para búsqueda</label>
                                    <input type="text" class="form-control" id="newPersona" name="newPersona" required>
                                    <input type="hidden" id="idPersona" name="idPersona">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnNuevoAlumno">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('vendors/autocomplete/src/jquery.autocomplete.js') !!}
    {!! Html::script('js/modulos/procesos/modulos/listaralumnos.js') !!}
@stop