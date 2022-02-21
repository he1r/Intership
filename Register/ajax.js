$(document).ready(function() {

    //SIGN UP BUTTON ON CLICK EVENT
    $("#register_button").click(function(e) {

        e.preventDefault();

        /**
         * GET THE INPUT DATA FROM THE INPUT FIELDS
         */
        var Emri = document.getElementById("register_emri").value;
        var Mbiemri = document.getElementById("register_mbiemri").value;
        var Atesia = document.getElementById("register_atesia").value;
        var Email = document.getElementById("register_email").value;
        var Nr_Tel = document.getElementById("register_phone").value;
        var Password = document.getElementById("register_password").value;
        var Datelindja = document.getElementById("register_datelindja").value;

        // EMRI VALIDATION
        if (!onlyLettersRegex.test(Emri)) {
            //SHOW THE ERROR
            document.getElementById('register_emri_error').innerHTML = "Emri duhet te kete vetem shkronja!";
            document.getElementById("register_emri").style.borderColor = "red";
            //REMOVE THE ERROR AFTER A PERIOD OF TIME
        } else {
            document.getElementById('register_emri_error').innerHTML = "";
            document.getElementById("register_emri").style.borderColor = "green";
        }

        //MBIEMRI VALIDATION
        if (!onlyLettersRegex.test(Mbiemri)) {
            //SHOW THE ERROR
            document.getElementById('register_mbiemri_error').innerHTML = "Mbiemri duhet te kete vetem shkronja!";
            document.getElementById("register_mbiemri").style.borderColor = "red";
        } else {
            document.getElementById('register_mbiemri_error').innerHTML = "";
            document.getElementById("register_mbiemri").style.borderColor = "green";
        }

        //ATESIA VALIDATION
        if (!onlyLettersRegex.test(Atesia)) {
            //SHOW THE ERROR
            document.getElementById('register_atesia_error').innerHTML = "Atesia duhet te kete vetem shkronja!";
            document.getElementById("register_atesia").style.borderColor = "red";
        } else {
            document.getElementById('register_atesia_error').innerHTML = "";
            document.getElementById("register_atesia").style.borderColor = "green";
        }

        //NR TEL VALIDATION
        if (!onlyNumbersRegex.test(Nr_Tel)) {
            //SHOW THE ERROR
            document.getElementById('register_phone_error').innerHTML = "Phone Number duhet te kete vetem numra!";
            document.getElementById("register_phone").style.borderColor = "red";
        } else {
            document.getElementById('register_phone_error').innerHTML = "";
            document.getElementById("register_phone").style.borderColor = "green";
        }

        //EMAIL VALIDATION
        if (!emailRegex.test(Email)) {
            //SHOW THE ERROR
            document.getElementById('register_email_error').innerHTML = "Emaili qe vendoset nuk eshte i sakte!";
            document.getElementById("register_email").style.borderColor = "red";
        } else {
            document.getElementById('register_email_error').innerHTML = "";
            document.getElementById("register_email").style.borderColor = "green";
        }

        //PASSWORD VALIDATION
        if (!passwordRegex.test(Password)) {
            //SHOW THE ERROR
            document.getElementById('register_password_error').innerHTML = "Passwordi duhet te kete nje shkronje te madhe nje numer dhe nje karakter special!";
            document.getElementById("register_password").style.borderColor = "red";
        } else {
            document.getElementById('register_password_error').innerHTML = "";
            document.getElementById("register_password").style.borderColor = "green";
        }

        //DATELINDJA VALIDATION
        if (!Datelindja) {
            //SHOW THE ERROR
            document.getElementById('register_datelindja_error').innerHTML = "Datelindja nuk duhet te jete bosh!";
            document.getElementById("register_datelindja").style.borderColor = "red";
        } else {
            document.getElementById('register_datelindja_error').innerHTML = "";
            document.getElementById("register_datelindja").style.borderColor = "green";
        }

        $.ajax({
            type: "POST",
            url: "./backend.php",
            data: {
                action: 'sign_up',
                emri: Emri,
                mbiemri: Mbiemri,
                atesia: Atesia,
                email: Email,
                nr_tel: Nr_Tel,
                password: Password,
                datelindja: Datelindja,
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
                    window.location.href = '../LogIn/'
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
})