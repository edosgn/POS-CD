$('.table-data').dataTable({
    stateSave: true,
    ordering: false,
    lengthMenu: [ 15 ],
    language: {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "_START_ al _END_ de _TOTAL_",
        "sInfoEmpty":      "0 registros al 0 de 0 ",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "S",
            "sPrevious": "A"
        }
    }
});
$('.dataTables_filter input').attr('placeholder','Buscar...');

