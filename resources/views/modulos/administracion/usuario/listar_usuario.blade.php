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
                            {!!  isset($htmlUsuario)?$htmlUsuario:'' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="mdlPermisos">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" id="frmPermisos">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="dataAcceso" name="data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-key fa-lg"></i> &nbsp;Accesos de Usuario</h4>
                    </div>
                    <div class="modal-body" id="bodyPermisos">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnPermisos">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')

    <script>
        $(document).ready(function () {

            $('#tblUsuarios').DataTable({
                responsive: true,
                searching: true,
                ordering: true,
                lengthChange: false
            });
        });

        function accion(data,accion)
        {
            var ac = accion == 0 ? 'Inactivar' : 'Activar';
            var token = $('meta[name=token]').attr("content");

            $.confirm({
                title: ac,
                icon: 'fa fa-question-circle',
                content: '¿Confirma que desea '+ac+' al usuario?',
                theme: 'modern',
                type: 'blue',
                typeAnimated: true,
                closeIcon: false,
                buttons: {
                    CANCELAR: function () {},
                    ACEPTAR: function () {
                        $.ajax({
                            type:'POST',
                            url:'accion',
                            data: {_token: token,data: data, accion: accion},
                            beforeSend: function() {
                                midialog = $.dialog({
                                    title: '<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>',
                                    content: '<h3>Procesando la información...</h3>',
                                    theme: 'supervan',
                                    type: 'blue',
                                    typeAnimated: true,
                                    closeIcon: false
                                });
                            }, error: function() {
                                midialog.close();
                                $.confirm({
                                    title: 'ERROR',
                                    content: 'La operación no pudo ser completada.',
                                    theme: 'dark',
                                    type: 'red',
                                    typeAnimated: true,
                                    closeIcon: false,
                                    buttons: {
                                        ACEPTAR: function () {}
                                    }
                                });
                            }, success: function(resp) {
                                var r = JSON.parse(resp);
                                if(r.status === 'OK')
                                    location.reload();
                                else
                                {
                                    midialog.close();
                                    $.confirm({
                                        title: 'ERROR',
                                        content: r.msg,
                                        theme: 'dark',
                                        type: 'red',
                                        typeAnimated: true,
                                        closeIcon: false,
                                        buttons: {
                                            ACEPTAR: function () {}
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }

        function permisos(data)
        {
            var token = $('meta[name=token]').attr("content");

            $.ajax({
                type:'POST',
                url:'permisos',
                data: {_token: token,data: data},
                beforeSend: function() {
                    midialog = $.dialog({
                        title: '<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>',
                        content: '<h3>Procesando la información...</h3>',
                        theme: 'supervan',
                        type: 'blue',
                        typeAnimated: true,
                        closeIcon: false
                    });
                }, error: function() {
                    midialog.close();
                    $.confirm({
                        title: 'ERROR',
                        content: 'La operación no pudo ser completada.',
                        theme: 'dark',
                        type: 'red',
                        typeAnimated: true,
                        closeIcon: false,
                        buttons: {
                            ACEPTAR: function () {}
                        }
                    });
                }, success: function(resp) {
                    midialog.close();
                    $('#dataAcceso').val(data);
                    $('#bodyPermisos').html(resp);
                    $('.flat').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});
                    $('#mdlPermisos').modal('show');
                }
            });
        }

        $(document).on('click','#btnPermisos',function () {
            $.confirm({
                title: 'PERMISOS DE USUARIO',
                icon: 'fa fa-key',
                content: '¿Desea actualizar los permisos del usuario?',
                theme: 'modern',
                type: 'blue',
                typeAnimated: true,
                closeIcon: false,
                buttons: {
                    CANCELAR: function () {},
                    ACEPTAR: function () {
                        $.ajax({
                            type:'POST',
                            url:'saveAccess',
                            data: $('#frmPermisos').serialize(),
                            beforeSend: function() {
                                midialog = $.dialog({
                                    title: '<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>',
                                    content: '<h3>Procesando la información...</h3>',
                                    theme: 'supervan',
                                    type: 'blue',
                                    typeAnimated: true,
                                    closeIcon: false
                                });
                            }, error: function() {
                                midialog.close();
                                $.confirm({
                                    title: 'ERROR',
                                    content: 'La operación no pudo ser completada.',
                                    theme: 'dark',
                                    type: 'red',
                                    typeAnimated: true,
                                    closeIcon: false,
                                    buttons: {
                                        ACEPTAR: function () {}
                                    }
                                });
                            }, success: function(resp) {
                                var r = JSON.parse(resp);
                                if(r.estado === 'OK')
                                    location.reload();
                                else
                                {
                                    midialog.close();
                                    $.confirm({
                                        title: 'ERROR',
                                        content: r.mensaje,
                                        theme: 'dark',
                                        type: 'red',
                                        typeAnimated: true,
                                        closeIcon: false,
                                        buttons: {
                                            ACEPTAR: function () {}
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        })

    </script>
@stop