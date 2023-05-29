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
    <h1 class="text-center mb-10">CHECKINS</h1>
    <fieldset class="text-center" id="dataTable">
    <table id="checkinsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>actions</th>
                <th>emri</th>
                <th>mbiemri</th>
                <th>hours_in</th>
                <th>hours_out</th>
            </tr>
        </thead>
    </table>
    </fieldset>

    <script src="../Includes/sidebar.js"></script>
    <script src="./ajax.js"></script>
</body>
