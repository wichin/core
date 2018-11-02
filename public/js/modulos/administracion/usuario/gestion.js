$(document).ready(function () {

});

$('#persona').autocomplete({
    serviceUrl: '../../miembros/gestion/buscar',
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