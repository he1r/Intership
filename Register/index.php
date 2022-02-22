<?php
include '../Includes/header.php'
?>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto py-1 px-0">
            <div class="card p-0">
                <div class="card-title text-center">
                    <h5 class="mt-5">SIGN UP</h5>
                </div>
                <form class="signup">
                    <div class="form-group">
                        <input type="text" id="register_emri" class="form-control" placeholder="Emri" required>
                        <span class="errors" id="register_emri_error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="register_mbiemri" class="form-control" placeholder="Mbiemri" required>
                        <span class="errors" id="register_mbiemri_error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="register_atesia" class="form-control" placeholder="Atesia" required>
                        <span class="errors" id="register_atesia_error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="register_email" class="form-control" placeholder="Email" required>
                        <span class="errors" id="register_email_error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="register_phone" class="form-control" placeholder="Phone" required>
                        <span class="errors" id="register_phone_error"></span>
                    </div>
                    <div class="form-group">
                        <input id="register_datelindja"class="form-control input--style-3 js-datepicker" type="text" placeholder="Datelindja" required>
                        <span class="errors" id="register_datelindja_error"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" autocomplete="off" id="register_password" class="form-control" placeholder="Password" required>
                        <span class="errors" id="register_password_error"></span>
                    </div>
                        <button type="button" class="btn btn-primary" id="register_button">Sign Up</button>
                </form>
                <a href="../LogIn/"><p class="text-center pt-2 mr-1">Already have an account?</p></a> 
            </div>
        </div>
    </div>
    <script src="./ajax.js"></script>
</div>
</body>
