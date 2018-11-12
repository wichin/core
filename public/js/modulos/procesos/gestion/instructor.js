$(document).ready(function () {
    validator = $('#frmInstructor').validate();

    $('#fecha').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false,
        showClear: true,
        locale: 'es'
    });

    $('#tblInstructores').DataTable({
        responsive: true,
        searching: true,
        ordering: true,
        lengthChange: false
    });
});

$(document).on('click','#btnNewElement',function () {
    try{validator.resetForm();}catch (e){}
    $('#frmInstructor')[0].reset();
    $('#mdlInstructor').modal('show');
});

$('#persona').autocomplete({
    serviceUrl: '../../miembros/gestion/busquedaInstructor',
    minChars: 3,
    showNoSuggestionNotice: true,
    noSuggestionNotice: 'No hay sugerencias...',
    onSelect: function (resp) {
        $('#idPersona').val(resp.data);
    },
    onInvalidateSelection: function () {
        $('#persona, #idPersona').val('');
    }
});

function accion(data, stat)
{
    var tipo = stat===0?'INACTIVAR':'ACTIVAR';
    $.confirm({
        icon: 'fa fa-question-circle',
        title: tipo+' INSTRUCTOR',
        content: '¿Confirma que desea '+tipo+' al Instructor?',
        theme: 'modern',
        type: 'blue',
        typeAnimated: true,
        closeIcon: true,
        buttons: {
            CANCELAR: function () {},
            ACEPTAR: {
                btnClass: 'btn-blue',
                action: function(){
                    var token = $('#token').val();
                    var info  = {_token: token, data: data, stat: stat};
                    $.ajax({
                        type:'POST',
                        url:'accionInstructor',
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

