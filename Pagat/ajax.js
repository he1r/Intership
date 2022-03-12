//INIT THE CHECKINS TABLE
var table = $('#pagatTable').DataTable({
    processing: true,
    serverSide: true,
    paging: true,
    serverMethod: 'POST',
    ajax: {
        url: "updateTable.php",
    },
    columns: [{
            data: "actions"
        },
        {
            data: "full_name"
        },
        {
            data: "ore_in_pushim"
        },
        {
            data: "ore_in_weekend"
        },
        {
            data: "ore_in_normal"
        },
        {
            data: "oret_in"
        },
        {
            data: "ore_out_pushim"
        },
        {
            data: "ore_out_weekend"
        },
        {
            data: "ore_out_normal"
        },
        {
            data: "oret_out"
        },
        {
            data: "oret_total"
        },
        {
            data: "paga_in_pushim"
        },
        {
            data: "paga_in_weekend"
        },
        {
            data: "paga_in_normal"
        },
        {
            data: "paga_total_in_hours"
        },
        {
            data: "paga_out_pushim"
        },
        {
            data: "paga_out_weekend"
        },
        {
            data: "paga_out_normal"
        },
        {
            data: "paga_total_out_hours"
        },
        {
            data: "paga_total"
        },
    ],
    columnDefs: [{
        targets: [1, 5, 9, 10, 14, 18, 19],
        className: 'nameColumn'
    }],
    drawCallback: function() {
        //ORET IN PUSHIM TOTAL
        oret_pushim_in_total_num = 0
        var oret_pushim_in_total = table.column(2).data()

        $.each(oret_pushim_in_total, function(index, value) {
            oret_pushim_in_total_num += value
        })
        //VENDOS TOTALIN E ORET_IN_PUSHIM NE FOOTER
        $("#oret_in_pushim_total").html(oret_pushim_in_total_num)

        //ORET IN WEEKEND TOTAL
        oret_weekend_in_total_num = 0
        var oret_weekend_in_total = table.column(3).data()

        $.each(oret_weekend_in_total, function(index, value) {
            oret_weekend_in_total_num += value
        })
        $("#oret_in_weekend_total").html(oret_weekend_in_total_num)

        //ORET IN NORMAL TOTAL
        oret_normal_in_total_num = 0
        var oret_normal_in_total = table.column(4).data()

        $.each(oret_normal_in_total, function(index, value) {
            oret_normal_in_total_num += value
        })
        $("#oret_in_normal_total").html(oret_normal_in_total_num)

        //ORET IN TOTAL
        oret_in_total_num = 0
        var oret_in_total = table.column(5).data()

        $.each(oret_in_total, function(index, value) {
            oret_in_total_num += value
        })
        $("#oret_in_total").html(oret_in_total_num)

        //ORET OUT PUSHIM TOTAL
        oret_out_pushim_total_num = 0
        var oret_out_pushim_total = table.column(6).data()

        $.each(oret_out_pushim_total, function(index, value) {
            oret_out_pushim_total_num += value
        })
        $("#oret_out_pushim_total").html(oret_out_pushim_total_num)

        //ORET OUT WEEKEND TOTAL
        oret_out_weekend_total_num = 0
        var oret_out_weekend_total = table.column(7).data()

        $.each(oret_out_weekend_total, function(index, value) {
            oret_out_weekend_total_num += value
        })
        $("#oret_out_weekend_total").html(oret_out_weekend_total_num)

        //ORET OUT NORMAL TOTAL
        oret_out_normal_total_num = 0
        var oret_out_normal_total = table.column(8).data()

        $.each(oret_out_normal_total, function(index, value) {
            oret_out_normal_total_num += value
        })
        $("#oret_out_normal_total").html(oret_out_normal_total_num)

        //ORET OUT TOTAL
        oret_out_total_num = 0
        var oret_out_total = table.column(9).data()

        $.each(oret_out_total, function(index, value) {
            oret_out_total_num += value
        })
        $("#oret_out_total").html(oret_out_total_num)

        //ORET ALL NE TOTAL
        oret_total_num = 0
        var oret_total = table.column(10).data()

        $.each(oret_total, function(index, value) {
            oret_total_num += value
        })
        $("#oret_total").html(oret_total_num)

        //PAGA IN PUSHIM TOTAL
        paga_in_pushim_total_num = 0
        var paga_in_pushim_total = table.column(11).data()

        $.each(paga_in_pushim_total, function(index, value) {
            paga_in_pushim_total_num += value
        })
        $("#paga_in_pushim_total").html(roundTwo(paga_in_pushim_total_num))

        //PAGA IN WEEKEND TOTAL
        paga_in_weekend_total_num = 0
        var paga_in_weekend_total = table.column(12).data()

        $.each(paga_in_weekend_total, function(index, value) {
            paga_in_weekend_total_num += value
        })
        $("#paga_in_weekend_total").html(roundTwo(paga_in_weekend_total_num))

        //PAGA IN NORMAL TOTAL
        paga_in_normal_total_num = 0
        var paga_in_normal_total = table.column(13).data()

        $.each(paga_in_normal_total, function(index, value) {
            paga_in_normal_total_num += value
        })
        $("#paga_in_normal_total").html(roundTwo(paga_in_normal_total_num))

        //PAGA IN TOTAL
        paga_in_total_num = 0
        var paga_in_total = table.column(14).data()

        $.each(paga_in_total, function(index, value) {
            paga_in_total_num += value
        })
        $("#paga_in_total").html(roundTwo(paga_in_total_num, 2))

        //PAGA OUT PUSHIM TOTAL
        paga_out_pushim_total_num = 0
        var paga_out_pushim_total = table.column(15).data()

        $.each(paga_out_pushim_total, function(index, value) {
            paga_out_pushim_total_num += value
        })
        $("#paga_out_pushim_total").html(roundTwo(paga_out_pushim_total_num))

        //PAGA OUT WEEKEND TOTAL
        paga_out_weekend_total_num = 0
        var paga_out_weekend_total = table.column(16).data()

        $.each(paga_out_weekend_total, function(index, value) {
            paga_out_weekend_total_num += value
        })
        $("#paga_out_weekend_total").html(roundTwo(paga_out_weekend_total_num))

        //PAGA OUT NORMAL TOTAL
        paga_out_normal_total_num = 0
        var paga_out_normal_total = table.column(17).data()

        $.each(paga_out_normal_total, function(index, value) {
            paga_out_normal_total_num += value
        })
        $("#paga_out_normal_total").html(roundTwo(paga_out_normal_total_num))

        //PAGA OUT TOTAL
        paga_out_total_num = 0
        var paga_out_total = table.column(18).data()

        $.each(paga_out_total, function(index, value) {
            paga_out_total_num += value
        })
        $("#paga_out_total").html(roundTwo(paga_out_total_num))

        //PAGA TOTAL

        paga_total_num = 0
        var paga_total = table.column(19).data()

        $.each(paga_total, function(index, value) {
            paga_total_num += value
        })
        $("#paga_total").html(paga_total_num)

    }
})

//FUNCTION TO ROUND THE NUMBER
function roundTwo(x) {
    return Number.parseFloat(x).toFixed(2);
}
//FORMAT THE DATA WE NEED FOR THE DETAILS ROWS
function format(d) {

    var row = "";
    //FOR EACH DATE CREATE A ROW THAT HAS ALL THE DATA
    $.each(d.details, function(index, value) {
        row += `<tr><td style="background-color: lightblue">${value.data}</td><td>${value.in_hours}</td><td>${value.out_hours}</td><td>${value.total_hours}</td><td>${value.payment_in_hurs}</td><td>${value.payment_out_hours}</td><td>${value.totale_payment}</td></tr>`
    });
    //THE TABLE THAT WILL SHOW AS ROW DETAILS
    var table = `
table>
    <thead>
        <tr style="background-color: orange">
            <th>date</th>
            <th>in_hours</th>
            <th>out_hours</th>
            <th>total_hours</th>
            <th>in_hours_payment</th>
            <th>out_hours_payment</th>
            <th>total_payment</th>
        </tr>
    </thead>
        ${row}
</table>`
    return table
}

//ON + BUTTON SHOW THE DETAILS IF THE DETAILS ARE CLOSE IF DETAILS ARE OPENED CLOSE THE DETAILS
$(document).on('click', '.showPagatDetails', function(e) {
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