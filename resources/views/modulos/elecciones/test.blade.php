@extends('layout.master')

@section('css')
    {!! Html::style('vendors/nprogress/nprogress.css') !!}
    <style>
        h1
        {
            padding: 0 !important;
            margin: 0 !important;
        }
        .step_no
        {
            padding-top: 3px !important;
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
                    {{-- STEPS --}}
                    <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                            <li>
                                <a href="#step-1">
                                    <span class="step_no" id="stepMaster">
                                        <i class="fa fa-times fa-2x"></i>
                                    </span>
                                    <span class="step_descr">
                                        <h2>Votación 1</h2>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-2" >
                                    <span class="step_no" id="stepMoney">
                                        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                                    </span>
                                    <span class="step_descr">
                                        <h2>Votación 2</h2>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-3">
                                    <span class="step_no" id="stepSecre">
                                        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                                    </span>
                                    <span class="step_descr">
                                        <h2>Votación 3</h2>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-4">
                                    <span class="step_no" id="stepVocal">
                                        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                                    </span>
                                    <span class="step_descr">
                                        <h2>Votación 4</h2>
                                    </span>
                                </a>
                            </li>
                        </ul>

                        <div id="step-1">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-info" role="alert">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h3>PRESIDENTE(A)</h3>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h1 id="votosPresi" style="text-align: right;"></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @if(isset($candidatos)&&count($candidatos)>0)
                                        @foreach($candidatos as $fila)
                                            <div class="row">
                                                @foreach($fila as $i => $item)
                                                    <a href="#" class="count presi" id="{{$item->idCandidato}}">
                                                        <div class="col-md-4 col-sm-4 col-xs-12 {{count($fila)!=3&&$i==0?(count($fila)==2?'col-md-offset-2 col-sm-offset-2 col-xs-offset-0':'col-md-offset-4 col-sm-offset-4 col-xs-offset-0'):''}} v-off-presi" style="background: #DDDDDD; color:#123456; border: 2px solid white;">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4 col-xs-4" style='text-align: center;'>
                                                                    @if(isset($item->foto)&&$item->foto!='')
                                                                        <img src="{!! asset($item->foto) !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @else
                                                                        <img src="{!! asset('images/silueta.png') !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                                    <h3>{{$item->nombre}}<br>{{$item->apellido}}</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif
                                    <br><br><br>
                                </div>
                            </div>
                        </div>
                        <div id="step-2">
                            <div class="row">
                                <div class="alert alert-success" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <h3>TESORERO(A)</h3>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <h1 id="votosMoney" style="text-align: right;"></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @if(isset($candidatos)&&count($candidatos)>0)
                                        @foreach($candidatos as $fila)
                                            <div class="row">
                                                @foreach($fila as $i => $item)
                                                    <a href="#" class="count money" id="{{$item->idCandidato}}">
                                                        <div class="col-md-4 col-sm-4 col-xs-12 {{count($fila)!=3&&$i==0?(count($fila)==2?'col-md-offset-2 col-sm-offset-2 col-xs-offset-0':'col-md-offset-4 col-sm-offset-4 col-xs-offset-0'):''}} v-off-money" style="background: #DDDDDD; color:#123456; border: 2px solid white;">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4 col-xs-4" style='text-align: center;'>
                                                                    @if(isset($item->foto)&&$item->foto!='')
                                                                        <img src="{!! asset($item->foto) !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @else
                                                                        <img src="{!! asset('images/silueta.png') !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                                    <h3>{{$item->nombre}}<br>{{$item->apellido}}</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif
                                    <br><br><br>
                                </div>
                            </div>
                        </div>
                        <div id="step-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h3>SECRETARIO(A)</h3>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h1 id="votosSecre" style="text-align: right;"></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @if(isset($candidatos)&&count($candidatos)>0)
                                        @foreach($candidatos as $fila)
                                            <div class="row">
                                                @foreach($fila as $i => $item)
                                                    <a href="#" class="count secre" id="{{$item->idCandidato}}">
                                                        <div class="col-md-4 col-sm-4 col-xs-12 {{count($fila)!=3&&$i==0?(count($fila)==2?'col-md-offset-2 col-sm-offset-2 col-xs-offset-0':'col-md-offset-4 col-sm-offset-4 col-xs-offset-0'):''}} v-off-secre" style="background: #DDDDDD; color:#123456; border: 2px solid white;">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4 col-xs-4" style='text-align: center;'>
                                                                    @if(isset($item->foto)&&$item->foto!='')
                                                                        <img src="{!! asset($item->foto) !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @else
                                                                        <img src="{!! asset('images/silueta.png') !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                                    <h3>{{$item->nombre}}<br>{{$item->apellido}}</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif
                                    <br><br><br>
                                </div>
                            </div>
                        </div>
                        <div id="step-4">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-danger" role="alert">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h3>VOCALES</h3>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h1 id="votosVocal" style="text-align: right;"></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @if(isset($candidatos)&&count($candidatos)>0)
                                        @foreach($candidatos as $fila)
                                            <div class="row">
                                                @foreach($fila as $i => $item)
                                                    <a href="#" class="count vocal" id="{{$item->idCandidato}}">
                                                        <div class="col-md-4 col-sm-4 col-xs-12 {{count($fila)!=3&&$i==0?(count($fila)==2?'col-md-offset-2 col-sm-offset-2 col-xs-offset-0':'col-md-offset-4 col-sm-offset-4 col-xs-offset-0'):''}} v-off-vocal" style="background: #DDDDDD; color:#123456; border: 2px solid white;">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4 col-xs-4" style='text-align: center;'>
                                                                    @if(isset($item->foto)&&$item->foto!='')
                                                                        <img src="{!! asset($item->foto) !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @else
                                                                        <img src="{!! asset('images/silueta.png') !!}" alt="silueta" class="img-responsive img-thumbnail" style="max-height: 70px; margin: 5px;">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                                    <h3>{{$item->nombre}}<br>{{$item->apellido}}</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif
                                    <br><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- /STEPS --}}
                    <div id="divButtonFinal" hidden>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 col-xs-offset-0">
                                <button type="button" class="btn btn-success btn-lg col-md-12 col-sm-12 col-xs-12" id="btnVotacion">FINALIZAR VOTACION</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{url('/elecciones/votacion/test')}}" method="POST" id="frmEleccion">
        <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" id="data" name="data" value="">
    </form>
@stop

@section('js')
    {!! Html::script('vendors/fastclick/lib/fastclick.js') !!}
    {!! Html::script('vendors/nprogress/nprogress.js') !!}
    {!! Html::script('vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') !!}

    {!! Html::script('js/modulos/elecciones/test.js') !!}
    <script>
        $(document).ready(function () {
            $('#wizard').smartWizard();

            $('#wizard_verticle').smartWizard({
                transitionEffect: 'slide'
            });

            $('.buttonPrevious').addClass('btn btn-default btn-lg').html('<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;ANTERIOR');
            $('.buttonNext').addClass('btn btn-primary btn-lg').html('SIGUIENTE&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>');
            $('.buttonFinish').addClass('btn btn-success btn-lg').html('FINALIZAR&nbsp;&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i>').hide();
        });
    </script>
@stop