$(document).ready(function() {
    //LOAD THE DATATABLE AND THE DATA
    var table = $('#adminTable').DataTable({
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
                data: "atesia"
            },
            {
                data: "email"
            },
            {
                data: "nr_tel"
            },
            {
                data: "datelindja"
            },
            {
                data: "username"
            },
            {
                data: "role"
            }
        ],
    });
    //SHOW THE EDIT USER MODAL AND SEND THE DATA TO BACKEND
    $(document).on('click', '.edit_button', function(e) {

        //GET THE EDIT USER MODAL
        var modal = document.getElementById("password_modal");

        //SHOW THE EDIT USER MODAL
        modal.style.display = "block";
        //GET THE BUTTON ROW
        var currentRow = $(this).closest("tr");

        //GET THE ROW DATA FOR THE BUTTON ROW
        var id = currentRow.find("td:eq(0)").text();
        var emri = currentRow.find("td:eq(2)").text();
        var email = currentRow.find("td:eq(5)").text();
        var mbiemri = currentRow.find("td:eq(3)").text();
        var atesia = currentRow.find("td:eq(4)").text();
        var nr_tel = currentRow.find("td:eq(6)").text();
        var datelindja = currentRow.find("td:eq(7)").text();
        var username = currentRow.find("td:eq(8)").text();
        var role = currentRow.find("td:eq(9)").text();

        //FILL ALL THE EDIT INPUT FIELDS WITH THE VALUES FROM THE ROW
        document.getElementById("emri_admin").value = `${emri}`
        document.getElementById("mbiemri_admin").value = `${mbiemri}`;
        document.getElementById("atesia_admin").value = `${atesia}`;
        document.getElementById("phone_admin").value = `${nr_tel}`;
        document.getElementById("datelindja_admin").value = `${datelindja}`;
        document.getElementById("username_admin").value = `${username}`;
        document.getElementById("role_admin").value = `${role}`;
        document.getElementById("email_admin").value = `${email}`;

        //UPDATE USER BUTTON CLICK
        $(document).on('click', '#adminUpdateUser', function(e) {

            e.preventDefault();

            var Emri = document.getElementById("emri_admin").value;
            var Mbiemri = document.getElementById("mbiemri_admin").value;
            var Atesia = document.getElementById("atesia_admin").value;
            var Email = document.getElementById("email_admin").value;
            var Nr_Tel = document.getElementById("phone_admin").value;
            var Datelindja = document.getElementById("datelindja_admin").value;
            var Username = document.getElementById("username_admin").value;
            var Role = document.getElementById("role_admin").value;

            // EMRI VALIDATION
            if (!onlyLettersRegex.test(Emri)) {
                //SHOW THE ERROR
                document.getElementById('emri_admin_error').innerHTML = "Emri duhet te kete vetem shkronja!";
                //REMOVE THE ERROR AFTER A PERIOD OF TIME
            } else {
                document.getElementById('emri_admin_error').innerHTML = "";
            }

            //MBIEMRI VALIDATION
            if (!onlyLettersRegex.test(Mbiemri)) {
                //SHOW THE ERROR
                document.getElementById('mbiemri_admin_error').innerHTML = "Mbiemri duhet te kete vetem shkronja!";
            } else {
                document.getElementById('mbiemri_admin_error').innerHTML = "";
            }

            //ATESIA VALIDATION
            if (!onlyLettersRegex.test(Atesia)) {
                //SHOW THE ERROR
                document.getElementById('atesia_admin_error').innerHTML = "Atesia duhet te kete vetem shkronja!";
            } else {
                document.getElementById('atesia_admin_error').innerHTML = "";
            }

            //NR TEL VALIDATION
            if (!onlyNumbersRegex.test(Nr_Tel)) {
                //SHOW THE ERROR
                document.getElementById('phone_admin_error').innerHTML = "Phone Number duhet te kete vetem numra!";
            } else {
                document.getElementById('phone_admin_error').innerHTML = "";
            }

            //EMAIL VALIDATION
            if (!emailRegex.test(Email)) {
                //SHOW THE ERROR
                document.getElementById('email_admin_error').innerHTML = "Emaili qe vendoset nuk eshte i sakte!";

            } else {
                document.getElementById('email_admin_error').innerHTML = "";
            }

            //ROLE VALIDATION
            if (!emailRegex.test(Email)) {
                //SHOW THE ERROR
                document.getElementById('role_admin_error').innerHTML = "Emaili qe vendoset nuk eshte i sakte!";

            } else {
                document.getElementById('role_admin_error').innerHTML = "";
            }
            //DATELINDJA VALIDATION
            if (!Datelindja) {
                //SHOW THE ERROR
                document.getElementById('datelindja_admin_error').innerHTML = "Datelindja nuk duhet te jete bosh!";
            } else {
                document.getElementById('datelindja_admin_error').innerHTML = "";
            }
            //AJAX POST REQUEST TO SEND THE DATA TO backend.php
            $.ajax({
                type: "POST",
                url: "./backend.php",
                data: {
                    action: 'adminUpdateUser',
                    emri: Emri,
                    mbiemri: Mbiemri,
                    atesia: Atesia,
                    email: Email,
                    nr_tel: Nr_Tel,
                    datelindja: Datelindja,
                    username: Username,
                    role: Role,
                    id: id,
                },

                success: function(arr) {
                    var res = JSON.parse(arr);

                    if (res.status == "200") {
                        Swal.fire(res.message)
                        //REDRAW TABLE
                        table.ajax.reload();
                        return;
                    }
                    if (res.status == "404") {
                        Swal.fire(res.message)
                        return;
                    }
                    if (res.status == "401") {
                        console.lpg(res.message)
                        return;
                    }
                },
                error: function(xhr, status, error) {
                    alert(`${JSON.stringify(error)} | ${JSON.stringify(xhr)} | ${status}`)
                }
            })

        })
    })
    //REMOVE THE EDIT USER MODAL ON BUTTON CLICK
    $("#cancelUpdatePassword").click(function() {
        //GET THE EDIT USER MODAL
        var modal = document.getElementById("password_modal");

        //REMOVE THE EDIT USER MODAL
        modal.style.display = "none";
    })
    //ADMIN DELETE USER BUTTON
    $(document).on('click', '.admin_delete_user', function(e) {

        e.preventDefault();

        //GET THE BUTTON ROW
        var currentRow = $(this).closest("tr");

        //GET THE EMAIL CELL DATA FOR THE BUTTON ROW
        var email = currentRow.find("td:eq(5)").text();

        //CONFRIM ALERT (USER CHOOSES IF HE IS SURE TO DELETE THE USER)
        Swal.fire({
            title: 'Are you sure you want to delete this user?',
            showDenyButton: true,
            denyButtonText: `Don't delete`,
        }).then((result) => {

            //IF THE RESPONSE IS YES SEND THE REQUEST TO THE BACKEND TO DELETE THE USER
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: './backend.php',
                    data: {
                        action: 'deleteUser',
                        email: email,
                    },
                    success: function(arr) {

                        //PARSE THE DATA WE GET FROM BACKEND
                        var response = JSON.parse(arr)

                        /**
                         * CHECK THE RESPONSE FROM THE BACKEND
                         * 
                         * IF RESPONSE = 200 DELETE USER FROM THE DATABASE
                         * 
                         * IF RESPONSE == 404 SHOW THE ERROR MESSAGE (USER DOESNT GET DELETED)
                         */

                        if (response.status == "200") {
                            Swal.fire('User Succesfully deleted!', '', 'success')
                            table.ajax.reload()
                            return;
                        }
                        if (response.status == "404") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                            })
                            return;
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(`${JSON.stringify(error)} | ${JSON.stringify(xhr)} | ${status}`)
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('User has not been deleted!', '', 'info')
            }
        })
    });
    //ADD A NEW USER 
    $(document).on('click', '#addUser', function() {

        var Emri = document.getElementById("adminEmri").value;
        var Mbiemri = document.getElementById("adminMbiemri").value;
        var Atesia = document.getElementById("adminAtesia").value;
        var Email = document.getElementById("adminEmail").value;
        var Nr_Tel = document.getElementById("adminTel").value;
        var Datelindja = document.getElementById("adminDatelindja").value;


        //AJAX POST REQUEST TO SEND THE DATA TO backend.php
        $.ajax({
            type: "POST",
            url: "./backend.php",
            data: {
                action: 'adminAddUser',
                emri: Emri,
                mbiemri: Mbiemri,
                atesia: Atesia,
                email: Email,
                nr_tel: Nr_Tel,
                datelindja: Datelindja,
            },

            success: function(arr) {
                var res = JSON.parse(arr);

                if (res.status == "200") {
                    Swal.fire(res.message)

                    //REDRAW TABLE
                    table.ajax.reload();
                    return;
                }
                if (res.status == "404") {
                    Swal.fire(res.message)
                    return;
                }
            },
            error: function(xhr, status, error) {
                alert(`${JSON.stringify(error)} | ${JSON.stringify(xhr)} | ${status}`)
            }
        })
    })
})