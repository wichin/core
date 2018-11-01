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
                    @if(isset($diaconos)&&count($diaconos)>0)
                        @foreach($diaconos as $fila)
                            <div class="row">
                                @foreach($fila as $i => $item)
                                    <a href="#" class="count" id="{{$item->id_candidato}}">
                                        <div class="col-md-4 col-sm-4 col-xs-12 {{count($fila)!=3&&$i==0?(count($fila)==2?'col-md-offset-2 col-sm-offset-2 col-xs-offset-0':'col-md-offset-4 col-sm-offset-4 col-xs-offset-0'):''}} v-off" style="background: #DDDDDD; color:#123456; border: 2px solid white;">
                                            <div class="row">
                                                <div class="col-md-5 col-sm-5 col-xs-5" style='text-align: center;'>
                                                    @if(isset($item->url_foto)&&$item->url_foto!='')
                                                        <img src="{!! $item->url_foto !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 105px; margin: 5px;">
                                                    @else
                                                        <img src="{!! asset('images/silueta.png') !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 85px; margin: 5px;">
                                                    @endif
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-xs-7">
                                                    <h3>
                                                        {{$item->nombre}}
                                                        <br>
                                                        <?php
                                                            $ape = explode(' ',$item->apellido);
                                                            echo $ape[0];
                                                        ?>

                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-1 col-sm-6 col-sm-offset-1 col-xs-12 col-xs-offset-0">
                                <p id="txtVotos" style="font-size: 32px;">0 VOTOS</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <button class="btn btn-primary btn-lg col-md-12 col-sm-12 col-xs-12" id="total">
                                    GUARDAR
                                </button>
                            </div>
                        </div>
                    @else
                        <h3 style="text-align: center">NO EXISTEN CANDIDATOS PARA ESTA ELECCION...</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{url('/elecciones/votacion/diaconos')}}" method="POST" id="frmEleccion">
        <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" id="data" name="data" value="">
        <input type="hidden" id="elec" name="elec" value="{{isset($idEleccion)?$idEleccion:''}}">
    </form>
@stop

@section('js')
    {!! Html::script('js/modulos/elecciones/diaconos/votacion.js') !!}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#menu_toggle').click();
        })
    </script>
@stop