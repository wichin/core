$(document).ready(function () {
    $('#inicio, #final').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false,
        showClear: true,
        locale: 'es'
    });
});