//INIT THE CHECKINS TABLE
var table = $('#checkinsTable').DataTable({
    processing: true,
    serverSide: true,
    paging: true,
    serverMethod: 'POST',
    ajax: {
        url: "updateTable.php",
    },
    columns: [{
            data: "id"
        },
        {
            data: "actions"
        },
        {
            data: "emri"
        },
        {
            data: "mbiemri"
        },
        {
            data: "hours_in"
        },
        {
            data: "hours_out"
        },
    ],
});

//FORMAT THE DATA WE NEED FOR THE DETAILS ROWS
function format(d) {

    var row = "";

    //FOR EACH DATA IN THE ARRAY CREATE A NEW ROW
    for (var i = 0; i < 10; i++) {
        row += `<tr><td style="background-color: lightblue">${d.details[i].date}</td><td>${d.details[i].check_in_hour}</td><td>${d.details[i].check_out_hour}</td></tr>`
    }

    //THE TABLE THAT WILL SHOW AS ROW DETAILS
    var table = `
table>
    <thead>
        <tr style="background-color: orange">
            <th>date</th>
            <th>check_in_hour</th>
            <th>check_out_hour</th>
        </tr>
    </thead>
        ${row}
</table>`
    return table
}

//ON + BUTTON SHOW THE DETAILS IF THE DETAILS ARE CLOSE IF DETAILS ARE OPENED CLOSE THE DETAILS
$(document).on('click', '.showDetails', function(e) {

    var tr = $(this).parents('tr');
    var row = table.row(tr);

    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    } else {
        // Open this row
        row.child(format(row.data())).show()
        tr.addClass('shown');
    }
});