@extends('layout.master')

@section('contenido')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{$titulo}}<small>{{$subtitulo}}</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(isset($response))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{$response}}
                            </div>
                        </div>
                    @endif
                    <form action="{{url('proceso/crear')}}" method="post">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-8">
                                <div class="form-group">
                                    <label for="fecha">Fecha de Inicio</label>
                                    <input type="text" class="form-control" id="fecha" name="fecha" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="descripcion">Descripción del Proceso</label>
                                    <textarea class="form-control" rows="3" id="descripcion" name="descripcion" required></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                    <label for="tipoproceso">Tipo Proceso</label>
                                    <select name="tipoproceso" id="tipoproceso" class="form-control" required>
                                        <option value=""></option>
                                        @foreach($catTipoProceso as $tp)
                                            <option value="{{$tp->idTipo_Proceso}}">{{$tp->Descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="estadoproceso">Estado Proceso</label>
                                    <select name="estadoproceso" id="estadoproceso" class="form-control" required>
                                        <option value=""></option>
                                        @foreach($catEstadoProceso as $ep)
                                            <option value="{{$ep->idEstado_Proceso}}">{{$ep->Descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                    <label for="cliente">Cliente</label>
                                    <select name="cliente" id="cliente" class="form-control" required>
                                        <option value=""></option>
                                        @foreach($catCliente as $c)
                                            <option value="{{$c->idEmpleado}}">{{$c->Nombre.' '.$c->Apellido}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="abogado">Abogado</label>
                                    <select name="abogado" id="abogado" class="form-control" required>
                                        <option value=""></option>
                                        @foreach($catAbogado as $ca)
                                            <option value="{{$ca->idEmpleado}}">{{$ca->Nombre.' '.$ca->Apellido}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary form-control">ACEPTAR</button>
                                <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop