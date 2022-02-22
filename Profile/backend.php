<?php
include '../Includes/connect_to_database.php';
include '../Includes/regex.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login/");
    exit;
}

// UPDATE USER PASSWORD
if ($_POST["action"] == 'updatePassword') {

    /**
     * MARRIM TE GJITHA TE DHENAT NGA PASSWORD INPUT FIELDS
     */
    $oldPassword = mysqli_real_escape_string($dbcon, $_POST["oldPassword"]);
    $newPassword = mysqli_real_escape_string($dbcon, $_POST["newPassword"]);
    $confirmPassword = mysqli_real_escape_string($dbcon, $_POST["confirmPassword"]);


    if (!preg_match($passwordRegex, $oldPassword) || !preg_match($passwordRegex, $newPassword) || !preg_match($passwordRegex, $confirmPassword)) {
        echo json_encode(array("status" => "401", "message" => "Password duhet te kete nje shkronje te madhe, nje numer, dhe nje karakter special!"));
        exit;
    }

    //MARRIM EMAILIN OSE NR_TEL E USERIT NGA SESIONI

    $user = $_SESSION["user"];

    /**
     * KONTROLLOJME NQFS OLD PASSWORD ESHTE I NJEJTE ME PASSWORDIN E VENDOSUR NGA USERI NE DATABAZE
     */

    // QUERY PER TE MARR ROW'N E PASSWORDIT
    $checkOldPassword = "SELECT * FROM users WHERE id = '$user'";

    /**
    * EKZEKUTOJME QUERYIN E OLD PASSWORD
    * CHECK NQFS EKZISTON ROW ME OLD PASSWORD QE MERRET NGA INPUT FIELD
    */

    $oldPasswordResult = mysqli_query($dbcon, $checkOldPassword);
    $passwordRow = mysqli_fetch_assoc($oldPasswordResult);
 
    /**
    * NQFS ROW EKZISTON
    * KONTROLLO NQFS PASSWORDI NE KTE ROW ESHTE I NJEJTE ME PASSWORDIN E DHENE NGA USERI
    */

    if ($passwordRow) {
        if ($passwordRow['password'] != md5($oldPassword)) {
            echo json_encode(array("status" => "404", "message" => "Passwordi nuk eshte i njejte me passwordin e meparshem!"));
            exit;
        }
    }
    
    /**
     * KONTROLLOJME NQFS NEW PASSWORD DHE CONFIRM PASSWORD JANE TE NJEJTE
     */
    
    if ($newPassword != $confirmPassword) {
        echo json_encode(array("status" => "404", "message" => "New password dhe Confirm New Password nuk jane te njejte!"));
    }

    $newPasswordHashed = md5($newPassword);
     
    //QUERY PER TE BERE UPDATE PASSWORDIN E USERIT
    $updatePasswordQuery = "UPDATE `users` SET `password`='$newPasswordHashed'
                        WHERE id = '$user'";

    //EKZEKUTOJME QUERYN
    $updatePasswordResult = mysqli_query($dbcon, $updatePasswordQuery);
    
    if ($updatePasswordResult == "TRUE") {
        echo json_encode(array("status" => "200", "message" => "Passwordi u be update!"));
        exit;
    }
}
//UPDATE USER DATA OR AVATAR
if ($_POST['action'] == 'updateUser') {

    /**
    * MARRIM TE DHENAT E USERIT QE VIJNE NGA FRONT END
    */

    $emri = mysqli_real_escape_string($dbcon, $_POST["emri"]);
    $mbiemri = mysqli_real_escape_string($dbcon, $_POST["mbiemri"]);
    $atesia = mysqli_real_escape_string($dbcon, $_POST["atesia"]);
    $nr_tel = mysqli_real_escape_string($dbcon, $_POST["nr_tel"]);
    $email = mysqli_real_escape_string($dbcon, $_POST["email"]);
    $datelindja = mysqli_real_escape_string($dbcon, $_POST["datelindja"]);
    $username = mysqli_real_escape_string($dbcon, $_POST["username"]);

    /**
    * VERIFIKOJM NQFS DATELINDJA INPUT FIELD ESHTE EMPTY
    */
    if (empty($datelindja)) {
        echo json_encode(array("status" => "401", "message" => "Datelindja input is empty!"));
        exit;
    }
    if (!preg_match($lettersRegex, $emri) || !preg_match($lettersRegex, $mbiemri) || !preg_match($lettersRegex, $atesia)) {
        echo json_encode(array("status" => "401", "message" => "Emri, mbiemri, atesia nuk duhet te jene bosh dhe duhet te kene vetem shkronja!"));
        exit;
    }
    if (!preg_match($emailRegex, $email)) {
        echo json_encode(array("status" => "401", "message" => "Email eshte gabim!"));
        exit;
    }
    if (!preg_match($nr_telRegex, $nr_tel)) {
        echo json_encode(array("status" => "401", "message" => "Phone number duhet te kete vetem numra"));
        exit;
    }

    /**
    * MARRIM NGA SESIONI ID E USERIT
    */

    $user = $_SESSION["user"];


    // QUERY TO GET THE USER ROW WITH THE USER ID WE GET FROM THE SESSION
    $getUserRow = "SELECT * FROM users WHERE id= '$user'";

    /**
    * CHECK NQFS EKZISTON ROW
    */

    $getRowResult = mysqli_query($dbcon, $getUserRow);
    $userRow = mysqli_fetch_assoc($getRowResult);

    if ($userRow) {
        $emailInitialValue = $userRow['email'];
        $nr_tel_initialValue = $userRow['nr_tel'];
    }

    /**
    * NQFS VLERA E EMAILIT KUR BEHET LOAD FAQJA ESHT NDRYSHE NGA VLERA E EMAILIT KUR USERI KLIKON BUTONIN UPDATE
    * KONTROLLO NQFS EMAILI I RI EKZISTON NE DATABAZE
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

    if ($nr_tel_initialValue != $nr_tel) {

        // QUERY PER TE MARR ROW'N E NR_TEL
        $TelExistsQuery = "SELECT * FROM users WHERE nr_tel= '$nr_tel'";

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
            if ($TelRow['nr_tel'] == $nr_tel) {
                echo json_encode(array("status" => "404", "message" => "Phone Number already exists!"));
                exit;
            }
        }
    };

    //GET THE IMAGE FROM THE POST REQUEST
    $img = $_FILES['file']['name'];
            
    //KRIJOJM RANDOM NUMBERS NGA 1 DERI NE 1000 PER TU MOS U BERE UPLOAD NJE IMAZH ME EMER TE NJEJTE
    $final_image = rand(1, 1000).$img;

    //THE FILE PATH TO BE UPLOADED IN THE DATABASE
    $file_path = '../Images/'. $final_image;

    /**
     * IF THERES AN IMAGE THE QUERY SHOULD HAVE SET AVATAR TO UPDATE THE AVATAR
     * IF THERES NO IMAGE UPLOADED BY USER THE QUERY SHOULD BE WITHOUT SET AVATAR TO UPDATE THE AVATAR
     *
     */

    if ($img) {

         //QUERY TO CHECK IF USER HAS ALREADY UPLOADED AN AVATAR BEFORE
        $checkAvatarQuery = "SELECT * FROM users WHERE id = '$user'";

        /**
        * EKZEKUTOJME QUERYIN E AVATARIT
        */

        $checkAvatarResult = mysqli_query($dbcon, $checkAvatarQuery);
        $avatarRow = mysqli_fetch_assoc($checkAvatarResult);
    
        /**
        * NQFS ROW EKZISTON
        * FSHIJ FOTON E VJETER DHE BEJ UPLOAD FOTON E RE
        */
        if ($avatarRow['avatar'] != '../DefaultImage/default.png') {
            unlink($avatarRow['avatar']);
        }

        $updateUserQuery = "UPDATE `users` 
                             SET `emri`='$emri',`mbiemri`='$mbiemri',`atesia`='$atesia',`nr_tel`= '$nr_tel',`email`='$email', `datelindja`='$datelindja',`username`='$username', `avatar` = '$file_path'
                             WHERE  id = '$user'";
    
        //BEJM MOVE IMAZHIN NE FOLDERIN E DHENE
        move_uploaded_file($_FILES['file']['tmp_name'], '../Images/' . $final_image);
    }
    if (!$img) {
        $updateUserQuery = "UPDATE `users` 
                             SET `emri`='$emri',`mbiemri`='$mbiemri',`atesia`='$atesia',`nr_tel`= '$nr_tel',`email`='$email', `datelindja`='$datelindja',`username`='$username' 
                             WHERE id = '$user' ";
    }
    //EKZEKUTOJME QUERYN
    $updateUserResult = mysqli_query($dbcon, $updateUserQuery);
   
    // NQFS RESULT == TRUE SEND FRONTEND THE RESPONSE
    if ($updateUserResult == "TRUE") {
        echo json_encode(array("status" => "200", "message" => "Te dhenat u bene update!"));
        exit;
    }
}
