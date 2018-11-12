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
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-success btn-sm" id="btnNewElement">
                                <i class="fa fa-user"></i> &nbsp;NUEVO INSTRUCTOR
                            </button>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(isset($html))
                        {!! $html !!}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="mdlInstructor">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <form action="{{url('/procesos/gestion/instructor')}}" method="POST" id="frmInstructor">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            <i class="fa fa-user fa-lg"></i> &nbsp;Agregar Instructor
                        </h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label for="persona">Ingrese nombres para búsqueda</label>
                                    <input type="text" class="form-control" id="persona" name="persona" required>
                                    <input type="hidden" id="idPersona" name="idPersona">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="fecha">Fecha Inicio</label>
                                    <input type="text" class="form-control" id="fecha" name="fecha" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@stop

@section('js')
    {!! Html::script('vendors/autocomplete/src/jquery.autocomplete.js') !!}
    {!! Html::script('js/modulos/procesos/gestion/instructor.js') !!}
@stop