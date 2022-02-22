<?php
include "../Includes/connect_to_database.php";
include '../Includes/regex.php';

/**
 *  CHECK IF USER SENDING THE REQUES IS AN ADMIN
 */
if($_SESSION["user"]){
    //THE USER ID
    $sessionId = $_SESSION["user"];

    //THE QUERY TO GET THE ID ROW FROM DATABASE
    $session_query = "SELECT * FROM users WHERE id= '$sessionId'";
    
    //EXECUTE THE QUERY
    $session_query_execute = mysqli_query($dbcon, $session_query);

    //GET THE ROW
    $session_result = mysqli_fetch_assoc($session_query_execute);

    //CHECK IF THE USER IN THE ROW IS ADMIN OR NOT
    if($session_result['user'] != "admin"){
        echo json_encode(array("status"=> "401", "message"=> "The user sending this request is not an admin"));
        exit;
    }
}

//ADMIN UPDATE USER BUTTON
if ($_POST["action"] == 'adminUpdateUser') {

    /**
    * MARRIM TE DHENAT E USERIT QE VIJNE NGA FRONT END
    */

    $emri = mysqli_real_escape_string($dbcon, $_POST["emri"]);
    $mbiemri = mysqli_real_escape_string($dbcon, $_POST["mbiemri"]);
    $atesia = mysqli_real_escape_string($dbcon, $_POST["atesia"]);
    $nr_Tel = mysqli_real_escape_string($dbcon, $_POST["nr_tel"]);
    $email = mysqli_real_escape_string($dbcon, $_POST["email"]);
    $datelindja = mysqli_real_escape_string($dbcon, $_POST["datelindja"]);
    $username = mysqli_real_escape_string($dbcon, $_POST["username"]);
    $role = mysqli_real_escape_string($dbcon, $_POST["role"]);

    $id = $_POST['id'];


    if(empty($datelindja)){
        echo json_encode(array("status" => "401", "message" => "Datelindja input is empty!"));
       exit;
      }
      if(!preg_match($lettersRegex, $emri) || !preg_match($lettersRegex, $mbiemri) || !preg_match($lettersRegex, $atesia) || !preg_match($lettersRegex, $role)){
        echo json_encode(array("status" => "401", "message" => "Emri, mbiemri, atesia, role nuk duhet te jene bosh dhe duhet te kene vetem shkronja!"));
      exit;
      }
      if(!preg_match($emailRegex, $email)){
        echo json_encode(array("status" => "401", "message" => "Email eshte gabim!"));
        exit;
      }
      if(!preg_match($nr_telRegex, $nr_Tel)){
        echo json_encode(array("status" => "401", "message" => "Phone number duhet te kete vetem numra"));
        exit;
      }

    /**
     * GET THE USERS EMAIL THAT IS IN DATABASE TO CHECK IF THE EMAIL INPUT FIELD VALUE HAS CHANGED 
     */

    $query_getUser_email =  "SELECT * FROM users WHERE id= '$id'";
    $query_execute = mysqli_query($dbcon, $query_getUser_email);
    $email_row = mysqli_fetch_assoc($query_execute);

    /**
     * NQFS ROW ME ID E MARRE EKZISTON ATHERE JEPI VARIABLAVE EMAIL AND NR INITIAL VALUE EMAILIN DHE NR_TEL NGA DATABASA
     */

    if($email_row){
        $emailInitialValue = $email_row['email'];
        $nr_tel_initialValue = $email_row['nr_tel'];
    }


    /**
    * VERIFIKOJM NQFS DATELINDJA INPUT FIELD ESHTE EMPTY
    */

    if (empty($datelindja)) {
        echo json_encode(array("status" => "404", "message" => "Datelindja is required!"));
        exit;
    }

    /**
    * NQFS VLERA E EMAILIT EKZISTON NE DATABAZE
    * KUR BEHET LOAD FAQJA ESHT NDRYSHE NGA VLERA E EMAILIT KUR USERI KLIKON BUTONIN UPDATE
    * KONTROLLO NQFS EMAILI I RI
    */

    if ($emailInitialValue != $email) {

        // QUERY PER TE MARR ROW'N E EMAILIT
        $emailExistsQuery = "SELECT * FROM users WHERE email= '$email'";

        /**
        * EKZEKUTOJME QUERYIN E EMAILIT
        * CHECK NQFS EKZISTON ROW ME EMAILIN QE MERRET NGA INPUT FIELD
        */

        $emailResult = mysqli_query($dbcon, $emailExistsQuery);
        $emailRow = mysqli_fetch_assoc($emailResult);
 
        /**
        * NQFS ROW EKZISTON
        * KONTROLLO NQFS EMAILI NE KTE ROW ESHTE I NJEJTE ME EMAILIN E DHENE NGA USERI
        */

        if ($emailRow) {
            if ($emailRow['email'] == $email) {
                echo json_encode(array("status" => "404", "message" => "Email already exists!"));
                exit;
            }
        }
    };
   
    /**
     * SIC BEME KRAHASIMIN ME LART PER EMAILIN TE NJEJTEN GJE DO TE BEJME DHE PER NR_TEL
     */

    if ($nr_tel_initialValue != $nr_Tel) {

        // QUERY PER TE MARR ROW'N E NR_TEL
        $TelExistsQuery = "SELECT * FROM users WHERE nr_tel= '$nr_Tel'";

        /**
        * EKZEKUTOJME QUERYIN E NR_TEL
        * CHECK NQFS EKZISTON ROW ME NR_TEL QE MERRET NGA INPUT FIELD
        */

        $TelResult = mysqli_query($dbcon, $TelExistsQuery);
        $TelRow = mysqli_fetch_assoc($TelResult);
 
        /**
        * NQFS ROW EKZISTON
        * KONTROLLO NQFS NR_TEL NE KTE ROW ESHTE I NJEJTE ME NR_TEL I DHENE NGA USERI
        */

        if ($TelRow) {
            if ($TelRow['nr_tel'] == $nr_Tel) {
                echo json_encode(array("status" => "404", "message" => "Phone Number already exists!"));
                exit;
            }
        }
    };

    /**
    * EKZEKUTOJME QUERYIN PER TE BERE UPDATE TE DHENAT E USERIT
    */

    $updateUserQuery = "UPDATE `users` SET `emri`='$emri',`mbiemri`='$mbiemri',`atesia`='$atesia',`nr_tel`='$nr_Tel',`email`='$email', `datelindja`='$datelindja',`username`='$username', `role`='$role' WHERE id= '$id'";
    $updateUserResult = mysqli_query($dbcon, $updateUserQuery);
   
    if ($updateUserResult == "TRUE") {
        echo json_encode(array("status" => "200", "message" => "Te dhenat u bene update!"));
        exit;
    }
}

//ADMIN DELETE USER BUTTON
if ($_POST['action'] == "deleteUser") {
    
    //GET THE EMAIL FROM THE POST DATA
    $email = $_POST['email'];

    //QUERY TO DELETE USER FROM DATABASE
    $deleteUserQuery = "DELETE FROM `users` WHERE email = '$email'";

    //EXECUTE QUERY
    $deleteUserResult = mysqli_query($dbcon, $deleteUserQuery);

    if ($deleteUserResult == "TRUE") {
        echo json_encode(array("status" => "200", "message"=> "User Deleted"));
        exit;
    } else {
        echo json_encode(array("status" => "404", "message" => "erorr user didnt get deleted"));
        exit;
    }
}

?>