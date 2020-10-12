$(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'lBfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );
} );



