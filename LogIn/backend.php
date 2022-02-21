<?php
//LOG IN PAGE BACKEND
include '../includes/connect_to_database.php';

session_start();

//LOGIN EVENT
if ($_POST["action"] == 'email_log_in') {
  
    /**
    * Marrim te dhenat e userit qe vijne nga front end
    */

    $username = mysqli_real_escape_string($dbcon, $_POST["username"]);
    $password = mysqli_real_escape_string($dbcon, $_POST["password"]);
    
    //QUERY TO CHECK IF THE EMAIL OR PHONE NUMBER ENTERED BY USER EXISTS IN DATABASE
    $existsQuery = "SELECT * FROM users WHERE email= '$username' or nr_tel= '$username'";

    /**
    * EKZEKUTOJME QUERYIN E EMAILIT
    * CHECK NQFS EKZISTON ROW ME EMAILIN QE MERRET NGA INPUT FIELD
    */

    $result = mysqli_query($dbcon, $existsQuery);
    $userRow = mysqli_fetch_assoc($result);

    /**
    * NQFS ROW EKZISTON CHECKOJM NQFS PASSWORD I VENDOSUR NGA USER MATCHES PASSWORDIN NE DATABAZE
    */
    
    if ($userRow) {
        if ($userRow['password'] == md5($password)) {

            //KRIJOHET SESIONI USER = EMAILIN E USERIT
            $_SESSION["user"] = $userRow["id"];
            $_SESSION['role'] = $userRow['role'];
            
            //RETURN THE DATA TO THE FRONTEND
            echo json_encode(array("status" => "200", "message" => "User Logs In"));

            exit;
        }else{
            echo json_encode(array("status"=> "401", "message" => "The password you entered is wrong!"));
            exit;
        }
    }else{
        echo json_encode(array("status" => "404", "message" => "The email or phone number you entered is wrong!"));
        exit;
    }
}
?>