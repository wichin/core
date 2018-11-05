$(document).ready(function (jQueryAlias) {
    $('#fecha').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: true,
        locale: {
            format: 'DD-MM-YYYY',
            daysOfWeek: [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            monthNames: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Dicuembre"
            ]
        }
    });
});

$('#persona').autocomplete({
    serviceUrl: '../../miembros/gestion/busquedaGeneral',
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