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
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-success btn-sm" id="btnNewElement">
                                <i class="fa fa-cog"></i> &nbsp;NUEVO MENÚ
                            </button>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @if(isset($html))
                                {!! $html !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="mdlMenu">
        <div class="modal-dialog" role="document">
            <form action="{{url('/admin/sistema/menu')}}" method="POST" id="frmMenu">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">
                            <i class="fa fa-cog fa-lg"></i>&nbsp; Crear Menú
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="modulo">Módulo</label>
                                    <select class="form-control" name="modulo" id="modulo" required>
                                        @if(isset($catModulo)&&count($catModulo)>0)
                                            <option value="" style="display: none;" selected>Seleccione...</option>
                                            @foreach($catModulo as $item)
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre de Menú</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('js/modulos/administracion/sistema/menu.js') !!}
@stop