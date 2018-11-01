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
        /*.x_panel
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
        }*/
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
                                <i class="fa fa-cog"></i> &nbsp;NUEVO MÓDULO
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

    <div class="modal fade" tabindex="-1" role="dialog" id="mdlModulo">
        <div class="modal-dialog" role="document">
            <form action="{{url('/admin/sistema/modulo')}}" method="POST" id="frmModulo">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">
                            <i class="fa fa-cog fa-lg"></i>&nbsp; Crear Módulo
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre de Módulo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="icono">Icono</label>
                                    <input type="text" class="form-control" id="icono" name="icono" required>
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
    {!! Html::script('js/modulos/administracion/sistema/modulo.js') !!}
@stop