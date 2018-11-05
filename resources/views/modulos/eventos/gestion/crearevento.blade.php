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
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-success btn-sm" id="btnNewElement">
                                <i class="fa fa-cog"></i> &nbsp;NUEVO EVENTO
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

    <div class="modal fade" tabindex="-1" role="dialog" id="mdlEvento">
        <div class="modal-dialog" role="document">
            <form action="{{url('/evento/gestion/crear')}}" method="POST" id="frmEvento">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">
                            <i class="fa fa-calendar fa-lg"></i>&nbsp; Crear Evento
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" maxlength="500" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="4" maxlength="1000" required></textarea>
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
    {!! Html::script('js/modulos/eventos/gestion/crearevento.js') !!}
@stop