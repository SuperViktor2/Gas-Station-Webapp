$(document).ready(function () {
    $('#tablica').DataTable({
        lengthMenu: [
            [5, 10, 25, -1],
            [5, 10, 25, 'All'],
        ],
    });
});
