<?php
include '../../Includes/connect_to_database.php';

//SEARCH VALUE NGA PHONE NUMBER SELECT2 FIELD
@$searchValue = mysqli_real_escape_string($dbcon, $_POST['q']);

//IF SEARCH VALUE BIGGER OR EQUAL THAN 3 CREATE THE QUERY WITH THE SEARCH VALUE
if (strlen($searchValue) >= 3) {
    $query = "AND (nr_tel LIKE '%" . $searchValue . "%')";
}

//THE QUERY DATA
@$query_data = "SELECT nr_tel
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

//WHILE THERE IS A NEW ROW ADD DATA TO THE DATA ARRAY
while ($row = mysqli_fetch_assoc($result_data)) {
    $data[] = array("id"=> $count, "text" => $row['nr_tel']);
    $count++;
}

echo json_encode($data);
exit;
