$(document).ready(function () {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        buttons: [
            {
            customize: function (win) {
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');

                $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                 }
            }
        ]

    });


    $( "#deleteUser" ).click(function() {
        if (confirm("Вы подтверждаете удаление?")) {
            return true;
        } else {
            return false;
        }
    });
});

