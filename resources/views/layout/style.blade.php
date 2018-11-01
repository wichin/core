{!! Html::style('vendors/bootstrap/dist/css/bootstrap.css') !!}
{!! Html::style('vendors/font-awesome/css/font-awesome.min.css') !!}
{!! Html::style('vendors/nprogress/nprogress.css') !!}
{!! Html::style('vendors/normalize-css/normalize.css') !!}
{!! Html::style('vendors/iCheck/skins/flat/blue.css') !!}
{!! Html::style('css/pnotify/pnotify.custom.min.css') !!}
{!! Html::style('css/jconfirm/jquery-confirm.css') !!}

@if(isset($isTable))
{{-- librerias para estilos de tablas --}}
{!! Html::style('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
{!! Html::style('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') !!}
{!! Html::style('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') !!}
{!! Html::style('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') !!}
{!! Html::style('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') !!}
@endif

@if(isset($isForm))
{{-- librerias para formularios --}}
{!! Html::style('vendors/bootstrap-daterangepicker/daterangepicker.css') !!}
@endif

{!! Html::style('build/css/custom.css') !!}

{{--custom elements--}}
<style>
    .modal-header
    {
        background: #337AB7 !important;
        color: white !important;
        border-top-left-radius: 3px !important;
        border-top-right-radius: 3px !important;
    }
</style>
