<?php
include '../Includes/header.php';
include '../Includes/connect_to_database.php';

session_start();

// Nese useri nuk ka session e cojme te login
if (!isset($_SESSION["user"])) {
    header("Location: ../LogIn/");
    exit;
}
    $username = $_SESSION["user"];

    $existsQuery = "SELECT * 
                    FROM users 
                    WHERE id = '$username'";

    /**
    * EKZEKUTOJME QUERYIN E EMAILIT
    * CHECK NQFS EKZISTON ROW ME EMAILIN
    */
    $result = mysqli_query($dbcon, $existsQuery);
    $userRow = mysqli_fetch_assoc($result);

    /**
    * NQFS ROW EKZISTON CHECKOJM DERGOJME TE DHENAT E USERIT
    */
    if ($userRow) {
        $emri = $userRow["emri"];
        $mbiemri = $userRow["mbiemri"];
        $role = $_SESSION['role'];
    }
?>
<body>
<div id="wrapper">
   <div class="overlay"></div>
    
    <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
     <ul class="nav sidebar-nav">
       <li style="margin-top: 5%;"><a href="../Welcome/">Welcome Page</a></li>
       <li><a href="../Profile/">Profile</a></li>
       <li><a href="../LogIn/">Log Out</a></li>
       <?php
       if ($role == "admin") {
           echo "<li><a href='../Admin/'>Administrator</a></li>";
       }
       ?>
     </ul>
  </nav>
            <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
        </div>
    <h1 class="text-center mb-10">ADMINISTRATOR</h1>
    <label for="emailSearch" style="margin-left: 55px">Email</label>  <label for="emailSearch" style="margin-left: 155px">Phone</label><br>
    <select style = 'margin-left: 100px; width: 200px;' class="js-example-basic-single" name="state"></select>  <select style = 'margin-left: 100px; width: 300px;' class="js-example-basic-multiple" style = 'width: 100px; margin-left: 30%;' name="state"></select>
    <button style= "margin-left:90%; width:150px" id= 'admin_add_user' class="btn">Add User</button>
    <fieldset class="text-center" id="dataTable">
    <table id="adminTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>actions</th>
                <th>emri</th>
                <th>mbiemri</th>
                <th>atesia</th>
                <th>email</th>
                <th>nr_tel</th>
                <th>datelindja</th>
                <th>username</th>
                <th>role</th>
                <th>avatar</th>
            </tr>
        </thead>
    </table>
    </fieldset>
   <!-- The Modal -->
<div id="password_modal" class="modal">
  <div class="modal-content" style="width: 20%; border: 4px solid black; border-radius: 10px">
                    <h5 class="text-center mt-7">EDIT USER</h5><br>
                            <div class="row-center">
                            <div class="img-circle text-center mb-3">
							<img style="width: 100px; height: 100px; border-radius: 50px;" id = 'admin_img' src="" alt="Image" class="shadow">
                            <form>
                                <br>
 						<input style="width: auto" class="btn btn-primary" type="file" id="admin_file" name="filename">
						</form>
						</div>
                            <div class="form-group" style="margin-left: 5%;">
								  	<label >Emri</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 5%;">
								  	<label >Mbiemri</label>
								  	<input type="text" id="mbiemri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="mbiemri_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 5%;">
								  	<label>Atesia</label>
								  	<input type="text" id="atesia_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="atesia_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 5%;">
								  	<label >Email</label>
								  	<input type="text" id="email_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="email_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 5%;">
								  	<label >Phone</label>
								  	<input type="text" id="phone_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="phone_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 5%;">
								  	<label >Datelindja</label>
                                      <input id="datelindja_admin"class="form-control input--style-3 js-datepicker" style="width: min-content" type="text" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="datelindja_admin_error"></span>
								</div>
                                <div class="form-group" style="margin-left: 5%;">
								  	<label >Username</label>
								  	<input type="text" id="username_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="username_admin_error"></span>
								</div>
                                <div class="form-group" style="margin-left: 5%;">
								  	<label >Role</label>
								  	<input type="text" id="role_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="role_admin_error"></span>
								</div>

						</div>
						
						<div>
							<button class="btn btn-primary" style = "margin-top: 22px" id="adminUpdateUser">Update</button>
							<button class="btn btn-primary" style = "margin-top: 22px" id="cancelUpdatePassword">Close</button>
						</div>
</div>
    </div>
 <!-- The Modal -->
 <div id="add_user_modal" class="modal">
  <div class="modal-content" style="width: 20%; border: 4px solid black; border-radius: 10px">
                    <h5 class="text-center mt-7">ADD USER</h5><br>
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
<div>
							<button class="btn btn-primary" style = "margin-top: 22px" id="admin_add_user_button">Add User</button>
							<button class="btn btn-primary" style = "margin-top: 22px" id="cancel_update_user_button">Close</button>
						</div>
</form>						
    </div>
    </div>
    <script src="../Includes/sidebar.js"></script>
    <script src="./ajax.js"></script>
</body>
