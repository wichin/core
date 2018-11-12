$(document).ready(function () {
    $('#tblProcesos').DataTable({
        responsive: true,
        searching: true,
        ordering: true,
        lengthChange: false
    });

    $("#proceso, #estado").select2({
        placeholder: "Seleccione...",
        allowClear: true
    });


    $('#fecha').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false,
        showClear: true,
        locale: 'es'
    });

    valFinalizar = $('#frmFinalizar').validate();

    valInstructor = $('#frmInstructores').validate({
        errorPlacement: function(error, element) {
            error.insertAfter("#error-instructor");
        }
    });
});

function accion(data,stat,nom)
{
    $.confirm({
        icon: 'fa fa-question fa-lg',
        title: nom+' MÓDULO',
        content: '¿Confirma que desea '+nom+' el Módulo Educativo?',
        theme: 'modern',
        type: 'blue',
        buttons: {
            CANCELAR: function () {},
            ACEPTAR: {
                text: 'ACEPTAR',
                btnClass: 'btn-blue',
                action: function(){
                    var token = $('#token').val();
                    var info  = {_token: token, data: data, stat: stat};
                    $.ajax({
                        type:'POST',
                        url:'estado',
                        data: info,
                        beforeSend: function() {
                            midialog = $.dialog({
                                title: '',
                                content: '<h3 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i><br><br>Procesando información...<br></h3>',
                                type: 'blue',
                                typeAnimated: true,
                                closeIcon: false
                            });
                        }, error: function() {
                            midialog.close();
                            $.confirm({
                                icon: 'fa fa-exclamation-circle',
                                title: 'ERROR EN TRANSACCIÓN',
                                content: 'No fue posible realizar la acción solicitada.',
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
                            console.log(resp);
                            var res = JSON.parse(resp);
                            if(res.ESTADO == 'OK')
                            {
                                location.reload();
                            }
                            else
                            {
                                $.confirm({
                                    icon: 'fa fa-exclamation-circle',
                                    title: 'ERROR EN TRANSACCIÓN',
                                    content: res.MENSAJE,
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
                    }); // Fin del ajax
                }
            }
        }
    });
}

function finaliza(data,stat,nom)
{
    $('#mdlFinalizar').modal('show');
    $('#dataF').val(data);
}

$(document).on('click','#btnFinalizar',function () {
    if(valFinalizar.form())
    {
        var token = $('#token').val();
        var dataF = $('#dataF').val();
        var fecha = $('#fecha').val();
        var info  = {_token: token, data: dataF, stat: 3,fecha:fecha};

        $.ajax({
            type:'POST',
            url:'estado',
            data: info,
            beforeSend: function() {
                midialog = $.dialog({
                    title: '',
                    content: '<h3 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i><br><br>Procesando información...<br></h3>',
                    type: 'blue',
                    typeAnimated: true,
                    closeIcon: false
                });
            }, error: function() {
                midialog.close();
                $.confirm({
                    icon: 'fa fa-exclamation-circle',
                    title: 'ERROR EN TRANSACCIÓN',
                    content: 'No fue posible realizar la acción solicitada.',
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
                console.log(resp);
                var res = JSON.parse(resp);
                if(res.ESTADO === 'OK')
                {
                    location.reload();
                }
                else
                {
                    $.confirm({
                        icon: 'fa fa-exclamation-circle',
                        title: 'ERROR EN TRANSACCIÓN',
                        content: res.MENSAJE,
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
        }); // Fin del ajax

    }
});

function instructor(data, name)
{
    $('#ttlInstructores').html(atob(name));

    var token = $('#token').val();
    var info  = {_token: token, data: data};

    $.ajax({
        type:'POST',
        url:'buscarInstructores',
        data: info,
        beforeSend: function() {
            midialog = $.dialog({
                title: '',
                content: '<h3 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i><br><br>Procesando información...<br></h3>',
                type: 'blue',
                typeAnimated: true,
                closeIcon: false
            });
        }, error: function() {
            midialog.close();
            $.confirm({
                icon: 'fa fa-exclamation-circle',
                title: 'ERROR EN TRANSACCIÓN',
                content: 'No fue posible realizar la acción solicitada.',
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
            console.log(resp);
            var res = JSON.parse(resp);
            if(res.ESTADO === 'OK')
            {
                $('#_dataI').val(data);
                $('#instructores').html('').append(res.MENSAJE).select2({
                    placeholder: "Seleccione..."
                });
                $('#mdlInstructores').modal('show');
            }
            else
            {
                $.confirm({
                    icon: 'fa fa-exclamation-circle',
                    title: 'ERROR EN TRANSACCIÓN',
                    content: res.MENSAJE,
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

$(document).on('click','#btnInstructores',function () {
    if(valInstructor.form())
    {
        $.ajax({
            type:'POST',
            url:'agregarInstructores',
            data: $('#frmInstructores').serialize(),
            beforeSend: function() {
                midialog = $.dialog({
                    title: '',
                    content: '<h3 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i><br><br>Procesando información...<br></h3>',
                    type: 'blue',
                    typeAnimated: true,
                    closeIcon: false
                });
            }, error: function() {
                midialog.close();
                $.confirm({
                    icon: 'fa fa-exclamation-circle',
                    title: 'ERROR EN TRANSACCIÓN',
                    content: 'No fue posible realizar la acción solicitada.',
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
                console.log(resp);
                var res = JSON.parse(resp);
                if(res.ESTADO == 'OK')
                {
                    location.reload();
                }
                else
                {
                    $.confirm({
                        icon: 'fa fa-exclamation-circle',
                        title: 'ERROR EN TRANSACCIÓN',
                        content: res.MENSAJE,
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
});