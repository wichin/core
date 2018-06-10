maxPresi = 3;
maxMoney = 2;
maxSecre = 3;
maxVocal = 4;

$(document).ready(function () {
    $('#votosPresi').html('0 de '+maxPresi+' votos');
    $('#votosMoney').html('0 de '+maxMoney+' votos');
    $('#votosSecre').html('0 de '+maxSecre+' votos');
    $('#votosVocal').html('0 de '+maxVocal+' votos');
});

$(document).on('click','.count',function () {
    var seccion = $(this).attr('class');

    if(seccion.indexOf('presi')!==-1)
    {
        var clasePresi = $(this).children().attr('class');
        if(clasePresi.indexOf('v-off-presi')!==-1)
        {
            var prevPresi = $('.v-on-presi').size();
            if(prevPresi<maxPresi)
                $(this).children().css({'background':'#123456','color':'#FFFFFF'}).removeClass('v-off-presi').addClass('v-on-presi');
        }
        else
            $(this).children().css({'background':'#DDDDDD','color':'#123456'}).removeClass('v-on-presi').addClass('v-off-presi');

        var cantPresi = $('.v-on-presi').size();
        $('#votosPresi').html(cantPresi+' de '+maxPresi+' votos');

        if(cantPresi==maxPresi)
            $('#stepMaster').html('<i class="fa fa-check fa-2x"></i>')
        else
            $('#stepMaster').html('<i class="fa fa-times fa-2x"></i>')
    }
    if(seccion.indexOf('money')!==-1)
    {
        var claseMoney = $(this).children().attr('class');
        if(claseMoney.indexOf('v-off-money')!==-1)
        {
            var prevMoney = $('.v-on-money').size();
            if(prevMoney<maxMoney)
                $(this).children().css({'background':'#123456','color':'#FFFFFF'}).removeClass('v-off-money').addClass('v-on-money');
        }
        else
            $(this).children().css({'background':'#DDDDDD','color':'#123456'}).removeClass('v-on-money').addClass('v-off-money');

        var cantMoney = $('.v-on-money').size();
        $('#votosMoney').html(cantMoney+' de '+maxMoney+' votos');

        if(cantMoney==maxMoney)
            $('#stepMoney').html('<i class="fa fa-check fa-2x"></i>');
        else
            $('#stepMoney').html('<i class="fa fa-times fa-2x"></i>');
    }
    if(seccion.indexOf('secre')!==-1)
    {
        var claseSecre = $(this).children().attr('class');
        if(claseSecre.indexOf('v-off-secre')!==-1)
        {
            var prevSecre = $('.v-on-secre').size();
            if(prevSecre<maxSecre)
                $(this).children().css({'background':'#123456','color':'#FFFFFF'}).removeClass('v-off-secre').addClass('v-on-secre');
        }
        else
            $(this).children().css({'background':'#DDDDDD','color':'#123456'}).removeClass('v-on-secre').addClass('v-off-secre');

        var cantSecre= $('.v-on-secre').size();
        $('#votosSecre').html(cantSecre+' de '+maxSecre+' votos');

        if(cantSecre==maxSecre)
            $('#stepSecre').html('<i class="fa fa-check fa-2x"></i>');
        else
            $('#stepSecre').html('<i class="fa fa-times fa-2x"></i>');
    }

    if(seccion.indexOf('vocal')!==-1)
    {
        var claseVocal= $(this).children().attr('class');
        if(claseVocal.indexOf('v-off-vocal')!==-1)
        {
            var prevVocal = $('.v-on-vocal').size();
            if(prevVocal<maxVocal)
                $(this).children().css({'background':'#123456','color':'#FFFFFF'}).removeClass('v-off-vocal').addClass('v-on-vocal');
        }
        else
            $(this).children().css({'background':'#DDDDDD','color':'#123456'}).removeClass('v-on-vocal').addClass('v-off-vocal');

        var cantVocal = $('.v-on-vocal').size();
        $('#votosVocal').html(cantVocal+' de '+maxVocal+' votos');

        if(cantVocal==maxVocal)
            $('#stepVocal').html('<i class="fa fa-check fa-2x"></i>');
        else
            $('#stepVocal').html('<i class="fa fa-times fa-2x"></i>');
    }

    /* CONTEO FINAL */
    var cantPresi = $('.v-on-presi').size();
    var cantMoney = $('.v-on-money').size();
    var cantSecre = $('.v-on-secre').size();
    var cantVocal = $('.v-on-vocal').size();

    if(cantPresi==maxPresi && cantMoney==maxMoney && cantSecre==maxSecre && cantVocal==maxVocal)
    {
        $('.buttonPrevious, .buttonNext').hide(500);
        $('#divButtonFinal').show(500);
    }
    else
    {
        $('.buttonPrevious, .buttonNext').show(500);
        $('#divButtonFinal').hide(500);
    }
});

$(document).on('click','#btnVotacion',function ()
{
    var cantPresi = $('.v-on-presi').size();
    var cantMoney = $('.v-on-money').size();
    var cantSecre = $('.v-on-secre').size();
    var cantVocal = $('.v-on-vocal').size();
    if(cantPresi==maxPresi && cantMoney==maxMoney && cantSecre==maxSecre && cantVocal==maxVocal)
    {
        var elecPresi = '';
        $('.presi').each(function( index ) {
            var cls = $(this).children().attr('class');
            if(cls.indexOf('v-on-presi') !== -1)
            {
                var vid = $(this).attr('id');
                elecPresi = (elecPresi.length===0)?vid:elecPresi+'|'+vid;
            }
        });

        var elecMoney = '';
        $('.money').each(function (index) {
            var cls = $(this).children().attr('class');
            if(cls.indexOf('v-on-money') !== -1)
            {
                var vid = $(this).attr('id');
                elecMoney = (elecMoney.length===0)?vid:elecMoney+'|'+vid;
            }
        });

        var elecSecre = '';
        $('.secre').each(function (index) {
            var cls = $(this).children().attr('class');
            if(cls.indexOf('v-on-secre') !== -1)
            {
                var vid = $(this).attr('id');
                elecSecre = (elecSecre.length===0)?vid:elecSecre+'|'+vid;
            }
        });

        var elecVocal = '';
        $('.vocal').each(function (index) {
            var cls = $(this).children().attr('class');
            if(cls.indexOf('v-on-vocal') !== -1)
            {
                var vid = $(this).attr('id');
                elecVocal = (elecVocal.length===0)?vid:elecVocal+'|'+vid;
            }
        });

        var elecTotal = elecPresi+':'+elecMoney+':'+elecSecre+':'+elecVocal;

        $('#data').val(elecTotal);
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
    else
    {
        $.confirm({
            title: 'ERROR',
            content: 'No es posible completar la votación, por favor actualice la página.',
            theme: 'dark',
            type: 'red',
            typeAnimated: true,
            closeIcon: false,
            buttons: {
                ACEPTAR: function () {
                    location.reload();
                }
            }
        });
    }
});