$(document).ready(function () {
    $('#total').hide();
});

$(document).on('click','.count',function () {
    var claseActual = $(this).children().attr('class');
    if(claseActual.indexOf('v-off') !== -1)
    {
        $(this).children().css({'background':'#123456','color':'#FFFFFF'}).removeClass('v-off').addClass('v-on');
        $(this).children().children().children().children().css({'border-color':'red'});
    }
    else
    {
        $(this).children().css({'background':'#DDDDDD','color':'#123456'}).removeClass('v-on').addClass('v-off');
        $(this).children().children().children().children().css({'border-color':'white'});
    }

    var cantidad = $('.v-on').size();
    $('#txtVotos').html(cantidad+' VOTOS');
    if(cantidad=='7')
        $('#total').show();
    else
        $('#total').hide();


});

$(document).on('click','#total',function () {
    var cantidad = $('.v-on').size();
    if(cantidad>0)
    {
        var elc = '';
        $('.count').each(function( index ) {
            var cls = $(this).children().attr('class');
            if(cls.indexOf('v-on') !== -1)
            {
                var vid = $(this).attr('id');
                elc = elc+'|'+vid;
            }
        });

        $('#data').val(elc);
        $('#frmEleccion').submit();

        $.dialog({
            title: '<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>',
            content: '<h3>Procesando la información...</h3>',
            theme: 'supervan',
            type: 'blue',
            typeAnimated: true,
            closeIcon: false
        });
    }
});