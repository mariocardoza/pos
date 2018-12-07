$(function(){
	App.datatables();
    $('#tipo_paro').dataTable({
        responsive: true,
        columnDefs: [
            { type: 'date-custom', targets: [1] },
            { orderable: false, targets: [2] }
        ],

        order: [[ 0, 'desc' ]],
        pageLength: 4,
        lengthMenu: [[4, 10, 30, -1], [4, 10, 30, 'Todo']]
    });

    $('#razonde_paro').dataTable({
        responsive: true,
        columnDefs: [
            { type: 'date-custom', targets: [1] },
            { orderable: false, targets: [2] }
        ],
        responsive:true,
        order: [[ 0, 'desc' ]],
        pageLength: 4,
        lengthMenu: [[4, 10, 30, -1], [4, 10, 30, 'Todo']]
    });


});