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
    <h1 class="text-center mb-10">PRODUKTET</h1>
    <table id= "produktetTable">
        <thead>
            <tr style="background-color: orange"> 
                <th>actions</th>
                <th>category_id</th>
                <th>category_name</th>
                <th>category_stock</th>
                <th>products_sold</th>
                <th>products_left</th>
                <th>xhiro</th>
                <th>shpenzime</th>
                <th>fitim</th>
            </tr>
    
                <?php
                include './test.php';

                foreach($result_data as $key => $row){
                    echo '<tr style="background-color:lightblue"><td><button class="showDetailsProdukt btn">+</button></td><td>' . $row['id'] .' </td><td>' .$row['category_name'] .'</td> <td> ' . $row['category_stock'] . ' </td><td> ' .$row['product_sold'] . ' </td><td>' .$row['category_stock'] - $row['product_sold'] . '</td><td>' .$row['xhiro'] .'</td><td>'. $row['shpenzim'] .'</td><td>'. $row['xhiro'] - $row['shpenzim'] . ' </td></tr>
                   <tr class="detailsProduktTs">
                    <td colspan= 10">
                    <table style="margin: 10px" class="produktDetailsRowTable">
                    <tr>
                    <th>actions</th>
                    <th>product_id</th>
                    <th>product_name</th>
                    <th>product_stock</th>
                    <th>products_sold</th>
                    <th>products left</th>
                    <th>xhiro</th>
                    <th>shpenzime</th>
                    <th>fitim</th>
                    </tr>
                    </table>
                    </td>
                    </tr>
                   ';
                }
                ?>
      
        </thead>
    </table>
    <script src="../Includes/sidebar.js"></script>
    <script src="./ajax.js"></script>
</body>
