$(document).ready(function() {

    //GET THE CHANGE PASSWORD MODAL
    var modal = document.getElementById("password_modal");

    //GET THE BUTTON THAT OPENS THE MODAL
    var open_modal = document.getElementById("change_password_modal");

    //SHOW THE MODAL
    open_modal.onclick = function() {
        modal.style.display = "block";
    }

    //GET THE BUTTON THAT CLOSES THE MODAL
    var cancel_button = document.getElementById("cancelUpdatePassword");
    //CLOSE THE MODAL ON BUTTON CLICK
    cancel_button.onclick = function() {
        modal.style.display = "none"
    }

    //UPDATE PASSWORD BUTTON
    $("#updatePasswordButton").click(function(e) {

        //STOP THE PAGE FROM RELOADING
        e.preventDefault()

        var oldPassword = document.getElementById("oldPassword").value;
        var newPassword = document.getElementById("newPassword").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        if (!passwordRegex.test(oldPassword)) {
            //SHOW THE ERROR
            document.getElementById('oldPasswordError').innerHTML = "Passwordi duhet te kete nje shkronje te madhe nje numer dhe nje karakter special!";
            //REMOVE THE ERROR AFTER A PERIOD OF TIME
        } else {
            document.getElementById('oldPasswordError').innerHTML = "";
        }

        //MBIEMRI VALIDATION
        if (!passwordRegex.test(newPassword)) {
            //SHOW THE ERROR
            document.getElementById('newPasswordError').innerHTML = "Passwordi duhet te kete nje shkronje te madhe nje numer dhe nje karakter special!";
        } else {
            document.getElementById('newPasswordError').innerHTML = "";
        }

        //ATESIA VALIDATION
        if (!passwordRegex.test(confirmPassword)) {
            //SHOW THE ERROR
            document.getElementById('confirmPasswordError').innerHTML = "Passwordi duhet te kete nje shkronje te madhe nje numer dhe nje karakter special!";
        } else {
            document.getElementById('confirmPasswordError').innerHTML = "";
        }

        $.ajax({
            type: "POST",
            url: "./backend.php",
            data: {
                action: 'updatePassword',
                oldPassword: oldPassword,
                newPassword: newPassword,
                confirmPassword: confirmPassword,
            },

            success: function(arr) {
                //BEJM PARSE TE DHENAT QE MARRIM NGA BACKEND
                var res = JSON.parse(arr);

                /**
                 * CHECK THE RESPONSE FROM THE BACKEND
                 * 
                 * IF RESPONSE = 200 SEND THE USER TO THE LOG IN DIRECTORY
                 * 
                 * IF RESPONSE == 404 SHOW THE ERROR MESSAGE
                 */

                if (res.status == "200") {
                    Swal.fire({
                        text: res.message,
                    })
                    return;
                }
                if (res.status == "404") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: res.message,
                    })
                    return;
                }
                if (res.status == "401") {
                    console.log(res.message)
                    return;
                }
            },
            error: function(xhr, status, error) {
                alert(`${JSON.stringify(error)} | ${JSON.stringify(xhr)} | ${status}`)
            }
        })
    })

    //UPDATE USER BUTTON ON CLICK EVENT
    $("#updateUserButton").click(function(e) {

        //STOP THE PAGE FROM RELOADING ON BUTTON CLICK
        e.preventDefault();

        var Emri = document.getElementById("profileEmri").value;
        var Mbiemri = document.getElementById("profileMbiemri").value;
        var Atesia = document.getElementById("profileAtesia").value;
        var Email = document.getElementById("profileEmail").value;
        var Nr_Tel = document.getElementById("profileNr_Tel").value;
        var Datelindja = document.getElementById("profileDatelindja").value;
        var Username = document.getElementById("profileUsername").value;

        // EMRI VALIDATION
        if (!onlyLettersRegex.test(Emri)) {
            //SHOW THE ERROR
            document.getElementById('emriError').innerHTML = "Emri duhet te kete vetem shkronja!";
            //REMOVE THE ERROR AFTER A PERIOD OF TIME
        } else {
            document.getElementById('emriError').innerHTML = "";
        }

        //MBIEMRI VALIDATION
        if (!onlyLettersRegex.test(Mbiemri)) {
            //SHOW THE ERROR
            document.getElementById('mbiemriError').innerHTML = "Mbiemri duhet te kete vetem shkronja!";
        } else {
            document.getElementById('mbiemriError').innerHTML = "";
        }

        //ATESIA VALIDATION
        if (!onlyLettersRegex.test(Atesia)) {
            //SHOW THE ERROR
            document.getElementById('atesiaError').innerHTML = "Atesia duhet te kete vetem shkronja!";
        } else {
            document.getElementById('atesiaError').innerHTML = "";
        }

        //NR TEL VALIDATION
        if (!onlyNumbersRegex.test(Nr_Tel)) {
            //SHOW THE ERROR
            document.getElementById('nr_telError').innerHTML = "Phone Number duhet te kete vetem numra!";
        } else {
            document.getElementById('nr_telError').innerHTML = "";
        }

        //EMAIL VALIDATION
        if (!emailRegex.test(Email)) {
            //SHOW THE ERROR
            document.getElementById('emailError').innerHTML = "Emaili qe vendoset nuk eshte i sakte!";

        } else {
            document.getElementById('emailError').innerHTML = "";
        }

        //DATELINDJA VALIDATION
        if (!Datelindja) {
            //SHOW THE ERROR
            document.getElementById('datelindjaError').innerHTML = "Datelindja nuk duhet te jete bosh!";
        } else {
            document.getElementById('datelindjaError').innerHTML = "";
        }

        // GET THE FILE SUBMITTED BY USER
        var file_data = $("#myFile").prop("files")[0]

        //CREATE A NEW FORM DATA
        var form_data = new FormData()

        //ADD THE FILE SUBMITTED BY USER TO THE FORM DATA ALSO ADD THE OTHER DATA FROM THE INPUT FIELDS
        form_data.append('file', file_data);
        form_data.append('action', "updateUser");
        form_data.append("emri", Emri);
        form_data.append("mbiemri", Mbiemri);
        form_data.append("atesia", Atesia);
        form_data.append("email", Email);
        form_data.append("nr_tel", Nr_Tel);
        form_data.append("datelindja", Datelindja);
        form_data.append("username", Username);

        //AJAX POST REQUEST TO SEND THE DATA TO backend.php
        $.ajax({
            url: "backend.php",
            type: "POST",
            data: form_data,
            contentType: false,
            processData: false,
            success: function(array) {

                //PARSE THE RESPONSE FROM THE BACKEND
                var response = JSON.parse(array)

                if (response.status == "200") {
                    Swal.fire({
                        title: response.message,
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        }
                    })
                    return;

                }
                if (response.status == "404") {
                    Swal.fire(response.message)
                    return;
                }
                if (response.status == "401") {
                    console.log(response.message)
                    return;
                }
            },
            error: function(xhr, status, error) {
                alert(`${JSON.stringify(error)} | ${JSON.stringify(xhr)} | ${status}`)
            }
        });
    })
})