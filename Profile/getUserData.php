<?php

//FILLOJME SESIONIN
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../LogIn/");
    exit;
}
    //MARRIM EMAILIN OSE NR_TEL NGA SESIONI USER
    $username = $_SESSION["user"];

    //QUERY TO GET THE ROW OF THE USER EMAIL OR NR_TEL
    $existsQuery = "SELECT * 
                    FROM users WHERE id = '$username'";

    /**
    * EKZEKUTOJME QUERYIN E EMAILIT
    * CHECK NQFS EKZISTON ROW ME EMAILIN
    */

    $result = mysqli_query($dbcon, $existsQuery);
    $userRow = mysqli_fetch_assoc($result);

    /**
    * NQFS ROW EKZISTON CHECKOJM MARRIM TE DHENAT E USERIT
    */
    
    //NQFS ROW EKZISTON MARRIM TE DHENAT E USERIT DHE I RUAJME NA VARIABLA
    if ($userRow) {
        $emri = $userRow["emri"];
        $mbiemri = $userRow["mbiemri"];
        $atesia = $userRow['atesia'];
        $datelindja = $userRow['datelindja'];
        $email = $userRow['email'];
        $nr_tel = $userRow['nr_tel'];
        $user = $userRow['username'];
        $avatar = $userRow['avatar'];
    }
