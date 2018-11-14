{!! Html::script('vendors/jquery/dist/jquery.js') !!}
{!! Html::script('vendors/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('vendors/fastclick/lib/fastclick.js') !!}
{!! Html::script('vendors/nprogress/nprogress.js') !!}
{!! Html::script('vendors/iCheck/icheck.js') !!}
{!! Html::script('js/jconfirm/jquery-confirm.js') !!}
{!! Html::script('js/pnotify/pnotify.custom.min.js') !!}
{!! Html::script('js/validator/dist/jquery.validate.js') !!}

@if(isset($isTable))
{{-- librerias para estilos de tablas --}}
{!! Html::script('vendors/datatables.net/js/jquery.dataTables.min.js') !!}
{!! Html::script('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') !!}
{!! Html::script('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') !!}
{!! Html::script('vendors/datatables.net-buttons/js/buttons.flash.min.js') !!}
{!! Html::script('vendors/datatables.net-buttons/js/buttons.html5.min.js') !!}
{!! Html::script('vendors/datatables.net-buttons/js/buttons.print.min.js') !!}
{!! Html::script('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') !!}
{!! Html::script('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') !!}
{!! Html::script('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') !!}
{!! Html::script('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') !!}
{!! Html::script('vendors/datatables.net-scroller/js/datatables.scroller.min.js') !!}
@endif

@if(isset($isForm))
{{-- librerias para formularios --}}
{!! Html::script('vendors/moment/moment.js') !!}
{!! Html::script('vendors/moment/locale/es.js') !!}
{!! Html::script('vendors/bootstrap-daterangepicker/daterangepicker.js') !!}
{!! Html::script('vendors/datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}
{!! Html::script('vendors/select2/dist/js/select2.js') !!}
{!! Html::script('vendors/select2/dist/js/i18n/es.js') !!}

{!! Html::script('vendors/parsleyjs/dist/parsley.js') !!}
{!! Html::script('vendors/parsleyjs/dist/i18n/es.js') !!}

{!! Html::script('js/validator/dist/jquery.validate.js') !!}
{!! Html::script('js/validator/dist/localization/messages_es.js') !!}
@endif

@if(isset($isChart))
{{--librerias para gráficas--}}
{!! Html::script('vendors/echarts/dist/echarts.js') !!}
{!! Html::script('vendors/echarts/style.js') !!}
@endif

{!! Html::script('build/js/custom.js') !!}
