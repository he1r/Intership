$(document).ready(function() {

    $('#adminTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "backend.php",
        "columnDefs": [{
            "data": null,
            "defaultContent": "<button class= 'btn' style='font-size: 12px; width:100px; height:30px; color:white;' id= 'edit_button' onclick = 'open_modal()'>Edit</button>",
            "targets": 1
        }]

    });
});