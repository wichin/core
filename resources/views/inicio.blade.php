@extends('layout.master')

@section('contenido')
    <div class="row" style="background: white;">
        <br>
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
            <h3>Asamblea de Dios Smirna</h3>
            <h4>4a. Av. 1-02 Zona 1. Chimaltenango, Guatemala.</h4>
            <hr>
        </div>
        <div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-10 col-xs-offset-1" id="index-vision">
            <h3>Nuestra visi&oacute;n</h3>
            <h4>Alcanzar y desarrollar personas por medio del mensaje del evangelio para ensanchar el Reino de Dios.</h4>
        </div>
        <div class="col-md-5 col-sm-5 col-xs-10 col-xs-offset-1">
            <h3>Misi&oacute;n</h3>
            <h4>Nuestra misi&oacuten se describe en un proceso de cinco pasos:</h4>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                    <li data-target="#myCarousel" data-slide-to="4"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        @if(isset($eng)&&$eng)
                            {!! Html::image('images/carrousel01.jpg', 'Alcanzar') !!}
                        @else
                            {!! Html::image('images/carrusel01.jpg', 'Alcanzar') !!}
                        @endif

                    </div>
                    <div class="item">
                        @if(isset($eng)&&$eng)
                            {!! Html::image('images/carrousel02.jpg', 'Consolidar') !!}
                        @else
                            {!! Html::image('images/carrusel02.jpg', 'Consolidar') !!}
                        @endif

                    </div>
                    <div class="item">
                        @if(isset($eng)&&$eng)
                            {!! Html::image('images/carrousel03.jpg', 'Discipular') !!}
                        @else
                            {!! Html::image('images/carrusel03.jpg', 'Discipular') !!}
                        @endif

                    </div>
                    <div class="item">
                        @if(isset($eng)&&$eng)
                            {!! Html::image('images/carrousel04.jpg', 'Desarrollar') !!}
                        @else
                            {!! Html::image('images/carrusel04.jpg', 'Desarrollar') !!}
                        @endif

                    </div>
                    <div class="item">
                        @if(isset($eng)&&$eng)
                            {!! Html::image('images/carrousel05.jpg', 'Enviar') !!}
                        @else
                            {!! Html::image('images/carrusel05.jpg', 'Enviar') !!}
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function(){
        $('.carousel').carousel();
    });
</script>
@stop