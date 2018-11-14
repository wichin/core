$(document).ready(function () {
    $("#proceso").select2({
        placeholder: "Seleccione...",
        allowClear: true
    });

    $("#modulo").select2({
        placeholder: "Pendiente...",
        allowClear: true
    });

    validaAlumno = $('#frmNuevoAlumno').validate();
});

$(document).on('click','#btnNewElement',function () {
    try{validaAlumno.resetForm();}catch (e){}
    $('#frmNuevoAlumno')[0].reset();
    $('#mdlNuevoAlumno').modal('show');
});

$('#newPersona').autocomplete({
    serviceUrl: '../../miembros/gestion/busquedaGeneral',
    minChars: 3,
    showNoSuggestionNotice: true,
    noSuggestionNotice: 'No hay sugerencias...',
    onSelect: function (resp) {
        $('#idPersona').val(resp.data);
    },
    onInvalidateSelection: function () {
        $('#newPersona, #idPersona').val('');
    }
});

$(document).on('change','#proceso',function () {
    var pro = $(this).val();

    if(pro!=='')
    {
        var token = $('#token').val();
        var info  = {_token: token, proceso: pro};
        $.ajax({
            type:'POST',
            url:'buscarModulo',
            data: info,
            beforeSend: function() {
                midialog = $.dialog({
                    title: '',
                    content: '<h3 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i><br><br>Buscando Módulos Educativos...<br></h3>',
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
                var res = JSON.parse(resp);
                if(res.ESTADO === 'OK')
                {
                    $('#modulo').empty().select2({
                        data: res.MENSAJE,
                        placeholder: "Seleccione...",
                        allowClear: true
                    })
                }
                else
                {
                    $("#modulo").html('').select2({
                        placeholder: "Pendiente...",
                        allowClear: true
                    }).trigger('change');

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
    else
    {
        $("#modulo").html('').select2({
            placeholder: "Pendiente...",
            allowClear: true
        }).trigger('change');
    }
});

function accion(data,stat,nom)
{
    $.confirm({
        icon: 'fa fa-question fa-lg',
        title: nom+' ALUMNO',
        content: '¿Confirma que desea '+nom+' al Alumno del Módulo Educativo?',
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
                        url:'estadoAlumno',
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

function nota(data,nom)
{
    $('#frmNota')[0].reset();
    $('#dataN').val(data);
    $('#ttlAlumno').html(nom);
    $('#mdlNota').modal('show');
}

$('#frmNota').submit(function (e) {
    e.preventDefault();

    $.ajax({
        type:'POST',
        url:'calificacion',
        data: $('#frmNota').serialize(),
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
    });
});