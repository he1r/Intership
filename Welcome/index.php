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
   <div class="card-title text-center">
   <h1>Welcome <?php echo $emri;?></h1>
    </div>
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
        <div id="page-content-wrapper">
            <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
        </div>
    </div>
    <script src="../Includes/sidebar.js"></script>
</body>
