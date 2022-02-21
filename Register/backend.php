<?php
//REGISTER EVENT
include '../Includes/regex.php';
include '../Includes/connect_to_database.php';

if ($_POST["action"] == 'sign_up') {
    /**
     * Marrim te dhenat e userit qe vijne nga front end
     */
    $emri = mysqli_real_escape_string($dbcon, $_POST["emri"]);
    $mbiemri = mysqli_real_escape_string($dbcon, $_POST["mbiemri"]);
    $atesia = mysqli_real_escape_string($dbcon, $_POST["atesia"]);
    $nr_Tel = mysqli_real_escape_string($dbcon, $_POST["nr_tel"]);
    $email = mysqli_real_escape_string($dbcon, $_POST["email"]);
    $password = mysqli_real_escape_string($dbcon, $_POST["password"]);
    $datelindja = mysqli_real_escape_string($dbcon, $_POST["datelindja"]);
    $Username = $emri[0].$mbiemri;
    $Role = "user";

if(empty($datelindja)){
  echo json_encode(array("status" => "401", "message" => "Datelindja input is empty!"));
 exit;
}
if(!preg_match($lettersRegex, $emri) || !preg_match($lettersRegex, $mbiemri) || !preg_match($lettersRegex, $atesia)){
  echo json_encode(array("status" => "401", "message" => "Emri, mbiemri, atesia nuk duhet te jene bosh dhe duhet te kene vetem shkronja!"));
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
if(!preg_match($passwordRegex, $password)){
  echo json_encode(array("status" => "401", "message" => "Password duhet te kete nje shkronje te madhe, nje numer, dhe nje karakter special!"));
  exit;
}

    /**
    * QUERYT PER TE PARE NQFS EMAILI DHE PASSWORD JANE NE DATABAZA
    */
  $emailExistsQuery = "SELECT * FROM users WHERE email= '$email'";
  $phoneExistsQuery = "SELECT * FROM  users WHERE nr_tel = '$nr_Tel'";

  /**
   * EKZEKUTOJME QUERYIN E EMAILIT
   * CHECK NQFS EKZISTON ROW ME EMAILIN QE MERRET NGA INPUT FIELD
   */
  $emailResult = mysqli_query($dbcon, $emailExistsQuery);
  $emailRow = mysqli_fetch_assoc($emailResult);
 
  if ($emailRow) {
    if ($emailRow['email'] == $email) {
        echo json_encode(array("status" => "404", "message" => "Email already exists!"));
        exit;
    }
  }

    /**
   * EKZEKUTOJME QUERYIN E PHONE NUMBER
   * CHECK NQFS EKZISTON ROW ME NR_TEL QE MERRET NGA INPUT FIELD
   */
  $phoneResult = mysqli_query($dbcon, $phoneExistsQuery);
  $phoneRow = mysqli_fetch_assoc($phoneResult);
  
  if ($phoneRow) {
    if ($phoneRow['nr_tel'] == $nr_Tel) {
        echo json_encode(array("status" => "404", "message" => "Phone Number already exists!"));
        exit;
    }
  }

    /**
   * EKZEKUTOJME QUERYIN PER TE SHTUAR NJE USER TE RI NE DATABAZE
   */
  $passwordHashed = md5($password);
    $insertUserQuery = "INSERT INTO users (emri, mbiemri, atesia, email, nr_tel, password, datelindja, username, role, avatar) VALUES ('$emri', '$mbiemri', '$atesia', '$email', '$nr_Tel', '$passwordHashed', '$datelindja', '$Username', '$Role', '../defaultImage/default.png')";
    $insertUserResult = mysqli_query($dbcon, $insertUserQuery);
    
    // NQFS RESULTATI I QUERIT == TRUE ATHERE NE DATABASE U SHTUA NJE USER I RI -- DERGO NE FRONTEND QE USERI U SHTUA
    if ($insertUserResult == "TRUE") {
        echo json_encode(array("status" => "200", "message" => "Te dhenat u rregjistruan!"));
        exit;
    }
}
?>