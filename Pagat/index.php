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
       <?php
       if ($role == "admin") {
           echo "<li><a href='../Produktet/'>Produktet</a></li>";
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
    <h1 class="text-center mb-10">PAGAT</h1>
    <fieldset class="text-center" id="dataTable" style="width: fit-content">
    <table id="pagatTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>actions</th>
                <th>emri</th>
                <th>oret_in_pushim</th>
                <th>oret_in_weekend</th>
                <th>oret_in_normal</th>
                <th>oret_in</th>
                <th>oret_out_pushim</th>
                <th>oret_out_weekend</th>
                <th>oret_out_normal</th>
                <th>oret_out</th>
                <th>total_ore</th>
                <th>paga_in_pushim</th>
                <th>paga_in_weekend</th>
                <th>paga_in_normal</th>
                <th>total_paga_in_hours</th>
                <th>paga_out_pushim</th>
                <th>paga_out_weekend</th>
                <th>paga_out_normal</th>
                <th>total_paga_out_hours</th>
                <th>total_paga</th>
            </tr>
        </thead>
        <tfoot>
            <tr style="background-color: red;">
                <th style="background-color: red" colspan= "2" id="total_paga">Total</th>
                <th id="oret_in_pushim_total"></th>
                <th id= "oret_in_weekend_total"></th>
                <th id="oret_in_normal_total"></th>
                <th style="background-color: red" id="oret_in_total"></th>
                <th id="oret_out_pushim_total"></th>
                <th id="oret_out_weekend_total"></th>
                <th id="oret_out_normal_total"></th>
                <th style="background-color: red" id= "oret_out_total"></th>
                <th style="background-color: red" id="oret_total"></th>
                <th id ="paga_in_pushim_total"></th>
                <th id="paga_in_weekend_total"></th>
                <th id="paga_in_normal_total"></th>
                <th style="background-color: red" id="paga_in_total"></tho>
                <th id="paga_out_pushim_total"></th>
                <th id="paga_out_weekend_total" ></th>
                <th id="paga_out_normal_total"></th>
                <th style="background-color: red" id="paga_out_total"></th>
                <th style="background-color: red" id = "paga_total"></th>
            </tr>
        </tfoot>
    </table>
    </fieldset>

    <script src="../Includes/sidebar.js"></script>
    <script src="./ajax.js"></script>
</body>
