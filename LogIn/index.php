<?php
include '../Includes/header.php';
?>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto py-4 px-0">
            <div class="card p-0">
                <div class="card-title text-center">
                    <h5 class="mt-5">LOG IN</h5>
                </div>
                <form class="signup">

                    <div class="form-group">
                        <input type="text" id="log_in_email_phone" class="form-control" placeholder="Email/Phone">
                        <span class="errors" id="email_phone_error"></span>
                    </div>

                    <div class="form-group">
                        <input type="password" id="log_in_password" class="form-control" placeholder="Password">
                        <span class="errors" id="password_error"></span>
                    </div>

                        <button type="button" class="btn btn-primary" id="log_in_button">Login</button>
                </form>
                <a href="../Register/"><p class="text-center pt-2 mr-1">Sign Up</p></a> 
            </div>
        </div>
    </div>
</div>
<script src="./ajax.js"></script>
</body>