$(document).ready(function () {

    $('#tblAplicacion').DataTable({
        responsive: true,
        searching: true,
        ordering: false,
        lengthChange: false
    });
});

$(document).on('click','#btnNewElement',function () {
    $('#menu').html('');
    $('#frmAplicacion')[0].reset();
    $('#mdlAplicacion').modal('show');
});

$(document).on('change','#modulo',function () {
    var modulo = $(this).val();

    if(modulo!=='')
    {
        var token = $('#token').val();
        var info  = {_token: token, data: modulo};
        $.ajax({
            type:'POST',
            url:'buscarMenu',
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
                    $('#menu').html(res.DATA);
                }
                else
                {
                    $('#menu').html('');
                    $('#modulo').val('');
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
        $('#menu').html('');
    }
});