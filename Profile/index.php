<?php
include '../Includes/header.php';
include '../Includes/connect_to_database.php';
include './getUserData.php';

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

    <!-- SIDEBAR NAV -->
<div id="wrapper">
   <div class="overlay"></div>
    
    <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
		
     <ul class="nav sidebar-nav">
       <li style="margin-top: 10%;"><a href="../Welcome/">Welcome Page</a></li>
       <li><a href="../Profile/">Profile</a></li>
       <li><a href="../LogIn/">Log Out</a></li>
       <?php
       if ($role == "admin") {
           echo "<li><a href='../Admin/'>Administrator</a></li>";
       }
       ?>
	     <?php
       if ($role == "admin") {
           echo "<li><a href='../Checkins/'>CheckIns</a></li>";
       }
       ?>
	    <?php
       if ($role == "admin") {
           echo "<li><a href='../Pagat/'>Pagat</a></li>";
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
    </div>

<!-- USER PROFILE -->
		<div class="container">
		<h1 class="text-center mb-5">PROFILE</h1>
			<div class="bg-white shadow rounded-lg d-block d-sm-flex">
				<div class="profile-tab-nav border-right">
					<div class="p-4">
					<h4 class="text-center"><?php echo $emri. " " .$mbiemri?></h4>
					
						<div class="img-circle text-center mb-3">
							<img style="width: 100px; height: 100px; border-radius: 50px;" src="<?php echo $avatar ?>" alt="Image" class="shadow">
						</div>
						
						<form>
 						<input style="width: auto" class="btn btn-primary" type="file" id="myFile" name="filename">
						</form>
					</div>
				</div>
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
					<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Emri</label>
								  	<input type="text" id="profileEmri" class="form-control" value="<?php echo $emri?>" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emriError"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Mbiemri</label>
								  	<input type="text" id="profileMbiemri" class="form-control" value="<?php echo $mbiemri?>" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="mbiemriError"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Atesia</label>
								  	<input type="text" id="profileAtesia" class="form-control" value="<?php echo $atesia?>"required >
									  <span class="errors" style="color: red; font-size: 15px;" id="atesiaError"></span>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Datelindja</label>
                                      <input id="profileDatelindja"class="form-control input--style-3 js-datepicker" type="text" value=<?php echo $datelindja; ?> required>
									  <span class="errors" style="color: red; font-size: 15px;" id="datelindjaError"></span>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Email</label>
								  	<input type="email" id="profileEmail" class="form-control" value="<?php echo $email?>"required>
									  <span class="errors" style="color: red; font-size: 15px;" id="emailError"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Phone Number</label>
								  	<input type="text" id="profileNr_Tel" class="form-control" value="<?php echo $nr_tel?>"required >
									  <span class="errors" style="color: red; font-size: 15px;" id="nr_telError"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Username</label>
								  	<input type="text" id="profileUsername" class="form-control" value="<?php echo $user?>" required>
								</div>
							</div>
						</div>
						<button class="btn btn-primary" id="updateUserButton">Update</button>
					</div>
					</div>
					
					<div>
						<br>
						<button style="width: 200px; margin-right: 20px;" class="btn btn-primary" id="change_password_modal">Change Password</button>
					</div>
<!-- The Modal -->
<div id="password_modal" class="modal">
  <div class="modal-content" style="border: 4px solid black; border-radius: 10px">
                    <h5 class="text-center mt-7">CHANGE PASSWORD</h5>
  <div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Old password</label>
								  	<input type="password" id="oldPassword" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="oldPasswordError"></span>

								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  	<label>New password</label>
								  	<input type="password" id="newPassword" class="form-control" required>
									<span class="errors" style="color: red; font-size: 15px;" id="newPasswordError"></span>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Confirm new password</label>
								  	<input type="password" id="confirmPassword" class="form-control" required>
									  <span class="errors" style="color: red; font-size: 15px;" id="confirmPasswordError"></span>

								</div>
							</div>
						</div>
						
						<div>
							<button class="btn btn-primary" style = "margin-top: 20px" id="updatePasswordButton">Update</button>
							<button class="btn btn-primary" style = "margin-top: 20px" id="cancelUpdatePassword">Close</button>
						</div>
</div>
    <script src="../Includes/sidebar.js"></script>
    <script src="./ajax.js"></script>
</body>
