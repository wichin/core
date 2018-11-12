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