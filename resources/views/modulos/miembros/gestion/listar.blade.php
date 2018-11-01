@extends('layout.master')
@section('css')

    <style>
        .panel:hover
        {
            background: white !important;
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
                            {!!  isset($htmlPersona)?$htmlPersona:'' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="mdlActualizar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('/miembros/gestion/agregar')}}" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-refresh fa-lg"></i> &nbsp;ACTUALIZAR INFORMACIÓN</h4>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">¿Confirma que desea actualizar la información de <span id="nmActualizar"></span>?</h3>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="dataActualizar" name="code">
                        <input type="hidden" id="appActualizar" name="apps" value="{{base64_encode('2')}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('js/modulos/miembros/gestion/listar.js') !!}
@stop