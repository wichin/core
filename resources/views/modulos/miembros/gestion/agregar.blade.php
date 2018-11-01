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
                    <form action="{{url('miembros/gestion/agregar')}}" method="POST" id="frmMiembro">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="code" value="{{isset($dt->id)&&$dt->id!=''?base64_encode($dt->id):''}}">
                        <input type="hidden" name="apps" value="{{isset($apps)?$apps:base64_encode(1)}}">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="nombres">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="data[nombre]" value="{{isset($dt->nombre)?$dt->nombre:''}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="data[apellido]" value="{{isset($dt->apellido)?$dt->apellido:''}}" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="cui">CUI</label>
                                    <input type="number" class="form-control" id="cui" name="data[cui]" value="{{isset($dt->cui)?$dt->cui:''}}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="data[telefono]" value="{{isset($dt->telefono)?$dt->telefono:''}}">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="sexo">Sexo</label>
                                        <select class="form-control" id="sexo" name="data[id_sexo]" required>
                                            <option value="" style="display: none;" selected>Seleccione...</option>
                                            @if(isset($catSexo))
                                                @foreach($catSexo as $item)
                                                    <option value="{{$item->id}}" {{isset($dt->Sexo->id)&&$dt->Sexo->id==$item->id?'selected':''}}>{{$item->descripcion}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="nacimiento">Fecha nacimiento</label>
                                    <input type="text" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{isset($nacimiento)&&$nacimiento!=''?$nacimiento:''}}" required>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="grupo">Grupo</label>
                                    <select class="form-control" name="data[id_grupo]" id="grupo" required>
                                        <option value="" style="display: none;" selected>Seleccione...</option>
                                        @if(isset($catGrupo))
                                            @foreach($catGrupo as $item)
                                                <option value="{{$item->id}}" {{isset($dt->Grupo->id)&&$dt->Grupo->id==$item->id?'selected':''}}>{{$item->descripcion}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <input type="hidden" name="miPick" id="miPick">
                            <div class="col-md-2 col-sm-3 col-xs-12">
                                <label>Captura</label>
                                <div id="my_camera"></div>
                                <input type="button" class="btn btn-success btn-sm" value="Capturar" onClick="take_snapshot()">
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12">
                                <div id="results">
                                    @if(isset($dt->url_foto)&&$dt->url_foto!='')
                                        <label>Vista Previa</label>
                                        <img src="{{$dt->url_foto}}" alt="..." class="img-thumbnail profile_img">
                                    @else
                                        <label>Vista Previa</label>
                                        <img src="{!! asset('images/silueta.png') !!}" alt="..." class="img-thumbnail">
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control" name="data[observaciones]" id="observaciones" rows="5" style="width: 100%;">{{isset($dt->observaciones)?$dt->observaciones:''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-3 col-xs-12 col-md-offset-10 col-sm-offset-9 col-xs-offset-0">
                                <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12">GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    {!! Html::script('js/webcam/webcam.min.js') !!}
    {!! Html::script('js/modulos/miembros/gestion/agregar.js') !!}
    <script>
    $(document).ready(function () {

        Webcam.set({
            width: 160,
            height: 120,

            dest_width: 160,
            dest_height: 120,

            crop_width: 120,
            crop_height: 120,

            image_format: 'jpeg',
            jpeg_quality: 72
        });
        Webcam.attach( '#my_camera' );
    });

    function take_snapshot() {
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            document.getElementById('results').innerHTML =
                '<label>Previsualización</label><br>' +
                '<img src="'+data_uri+'"/>';
            $('#miPick').val(data_uri);
        });
    }
    </script>
@stop