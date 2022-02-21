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
       <li style="margin-top: 10%;"><a href="../Welcome/">Welcome Page</a></li>
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
  <div class="modal-content" style="width: 40%; border: 4px solid black; border-radius: 10px">
                    <h5 class="text-center mt-7">EDIT USER</h5><br>
                            <div class="row-center">
                            <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Emri</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Mbiemri</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Atesia</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Email</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Phone</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>

                                <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Datelindja</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>
                                <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Username</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>
                                <div class="form-group" style="margin-left: 27%;">
								  	<label style="margin-left:25%;">Role</label>
								  	<input type="text" id="emri_admin" style="width: min-content;" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emri_admin_error"></span>
								</div>

						</div>
						
						<div>
							<button class="btn btn-primary" style = "margin-top: 20px" id="updatePasswordButton">Update</button>
							<button class="btn btn-primary" style = "margin-top: 20px" id="cancelUpdatePassword">Close</button>
						</div>
</div>
    <script src="./server_side.js"></script>
    <script src="../Includes/sidebar.js"></script>
    <script src="./ajax.js"></script>
</body>
