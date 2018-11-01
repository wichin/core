$(document).ready(function () {

    $('#tblPersona').DataTable({
        responsive: true,
        searching: true,
        ordering: true,
        lengthChange: false
    });
});

function actualizar(data, nm)
{
    $('#nmActualizar').html(nm);
    $('#dataActualizar').val(data);
    $('#mdlActualizar').modal('show');
}