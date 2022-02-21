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
       if($role == "admin"){
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
    <button style= "margin-left:90%; width:150px" class="btn">Add User</button>
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
            </tr>
        </thead>
    </table>
    </fieldset>
   <!-- The Modal -->
<div id="password_modal" class="modal">
  <div class="modal-content" style="width: 20%; border: 4px solid black; border-radius: 10px">
                    <h5 class="text-center mt-7">EDIT USER</h5><br>
                            <div class="row-center">
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
                                      <input id="datelindja_admin"class="form-control input--style-3 js-datepicker" type="text" required>
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
 <!-- The Modal -->
 <div id="add_user_modal" class="modal">
  <div class="modal-content" style="width: 20%; border: 4px solid black; border-radius: 10px">
                    <h5 class="text-center mt-7">ADD USER</h5><br>
                            <div class="row-center">
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
                                      <input id="datelindja_admin"class="form-control input--style-3 js-datepicker" type="text" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="datelindja_admin_error"></span>
								</div>
                                <div class="form-group" style="margin-left: 5%;">
                                    
                        <input type="password" autocomplete="off" id="register_password" class="form-control" placeholder="Password" required>
                        <span class="errors" id="register_password_error"></span>
                    </div>

						</div>
						
						<div>
							<button class="btn btn-primary" style = "margin-top: 22px" id="admin_add_user">Add User</button>
							<button class="btn btn-primary" style = "margin-top: 22px" id="cancel_update_user">Close</button>
						</div>
    <script src="./server_side.js"></script>
    <script src="../Includes/sidebar.js"></script>
    <script src="./ajax.js"></script>
</body>
