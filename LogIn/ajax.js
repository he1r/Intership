$(document).ready(function() {
    //LOG IN ON CLICK BUTTON EVENT
    $("#log_in_button").click(function(e) {

        //STOP THE PAGE RELOAD ON BUTTON CLICK
        e.preventDefault();

        //USER INPUT DATA FROM THE EMAIL/PHONE AND PASSWORD INPUT TEXT FIELDS
        var Username = document.getElementById("log_in_email_phone").value;
        var Password = document.getElementById("log_in_password").value;

        /**
         * SEND THE DATA FROM FRONTEND TO BACKEND TO CHECK IF THE EMAIL OR PHONE NUMBER EXISTS 
         * 
         * IF IT DOES EXIST OPEN WELCOME PAGE FOR THE USER
         */

        $.ajax({
            type: "POST",
            url: './backend.php',
            data: {
                action: 'email_log_in',
                username: Username,
                password: Password,
            },
            success: function(arr) {

                //PARSE THE RESPONSE WE GET FROM BACKEND
                var response = JSON.parse(arr)

                /**
                 * CHECK THE RESPONSE FROM THE BACKEND
                 * 
                 * IF RESPONSE = 200 OPEN THE WELCOMEPAGE DIRECTORY
                 * 
                 * IF RESPONSE == 404 SHOW THE ERROR MESSAGE
                 */

                if (response.status == "200") {
                    //IF THE RESPONSE IS 200 THAT MEANS THAT THE USER EXISTS IN THE DATABASE -- SEND USER TO THE WELCOMEPAGE DIRECTORY
                    window.location.href = '../Welcome/'
                    return;
                } else if (response.status == "404") {

                    //SHOW THE ERROR
                    document.getElementById('email_phone_error').innerHTML = response.message;

                    //REMOVE THE ERROR AFTER A PERIOD OF TIME
                    setTimeout(function() {
                        var elem = document.getElementById("email_phone_error");
                        elem.textContent = "";
                    }, 3500);

                    return;
                } else if (response.status == "401") {

                    //SHOW THE ERROR
                    document.getElementById('password_error').innerHTML = response.message;

                    //REMOVE THE ERROR AFTER A PERIOD OF TIME
                    setTimeout(function() {
                        var elem = document.getElementById("password_error");
                        elem.textContent = "";
                    }, 3500);

                    return;
                }
            },
            error: function(xhr, status, error) {
                alert(`${JSON.stringify(error)} | ${JSON.stringify(xhr)} | ${status}`)
            }
        })
    })
})