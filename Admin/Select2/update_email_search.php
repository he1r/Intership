<?php
include '../../Includes/connect_to_database.php';

//SEARCH VALUE FROM EMAIL SELECT2 FIELD
$searchValue = mysqli_real_escape_string($dbcon, $_POST['q']);

//IF SEARCH VALUE FROM EMAIL SELECT2 BIGGER OR EQUAL THAN 3 CREATE THE QUERY FOR THE SEARCH VALUE
if (strlen($searchValue) >= 3) {
    $query = "AND (email LIKE '%" . $searchValue . "%')";
}

//THE QUERY DATA FOR ALL THE EMAILS
$query_data = "SELECT email
               FROM users where 1 = 1   
               $query LIMIT 10";

//EXECUTE THE QUERY
$result_data = mysqli_query($dbcon, $query_data);

if (!$result_data) {
    $error = mysqli_error($dbcon) . " " . __LINE__;
    empty_data($totalRecords, $error);
}

$data = array();
$count = 1;
//WHILE NEW ROW ADD TO THE DATA ARRAY THE EMAIL
while ($row = mysqli_fetch_assoc($result_data)) {
    $data[] = array("id"=> $row['email'], "text" => $row['email']);
    $count++;
}

echo json_encode($data);
exit;
