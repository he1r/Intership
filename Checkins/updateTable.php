<?php

include "../Includes/connect_to_database.php";
/**
 * GET ALL THE DATA FROM THE TABLE
 */
$draw = $_POST['draw'];
$limit_start = $_POST['start'];
$limit_end = $_POST['length'];
$columnIndex = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir'];

    //GET THE SEARCH VALUE DATA FROM THE TABLE
    $searchValue = mysqli_real_escape_string($dbcon, $_POST['search']['value']);

    //SEARCH QUERY STRING
    $searchQuery = "";

    //IF THERES A SEARCH VALUE INPUT FROM USER CREATE QUERY
    if ($searchValue != '') {
        $searchQuery = " AND (users.id LIKE '%" . $searchValue . "%' OR 	
        users.emri LIKE '%" . $searchValue . "%' OR
        users.mbiemri LIKE '%" . $searchValue . "%')";
    }

    //HOW MANY ROWS SHOULD BE SHOWN IN THE DATATABLE
    $pagination = "LIMIT " . $limit_start . ", " . $limit_end;

    /**
     * MARRIM NUMRIN TOTAL TE REKORDEVE PA APLIKUAR FILTRAT SIC ESHT SEARCH VALUE
     */
    $query_without_ftl = "SELECT COUNT(*) AS allcount 
                      FROM users where 1 = 1 ";

    //EKZEKUTOJM QUERYN
    $result_without_ftl = mysqli_query($dbcon, $query_without_ftl);

    //MARRIM NUMRIN TOTAL TE REKORDEVE PA FILTER
    $records = mysqli_fetch_assoc($result_without_ftl);
    $totalRecords = $records['allcount'];

    /**
     * MARRIM NUMRIN TOTAL TE REKORDEVE DUKE APLIKUAR FILTRAT
     */

    $query_with_ftl = "SELECT COUNT(*) AS allcount 
                   FROM  users
                   WHERE 
                   id LIKE '%" . $searchValue . "%' OR 	
                   emri LIKE '%" . $searchValue . "%' OR
                   mbiemri LIKE '%" . $searchValue . "%'";
    $result_with_ftl = mysqli_query($dbcon, $query_with_ftl);

    if (!$result_with_ftl) {
        $error = mysqli_error($dbcon) . " " . __LINE__;
        empty_data($totalRecords, $error);
    }

    $records_with_ftl = mysqli_fetch_assoc($result_with_ftl);
    $totalRecordwithFilter = $records_with_ftl['allcount'];

    /**
     * BEHET PERLLOGARITJA E TE GJITHE TE DHENAVE QE DO TE DERGOHEN NE FRONTEND
     */
    $query_data = "SELECT users.id,
    users.emri,
    users.mbiemri,
    checkins.user_id,
   checkins.check_in_date,
   checkins.check_in_hour,
   checkins.check_out_date,
   checkins.check_out_hour
FROM users INNER JOIN checkins ON users.id = checkins.user_id where 1 = 1
$searchQuery ORDER BY  $columnName $columnSortOrder";

$result_data = mysqli_query($dbcon, $query_data);
if (!$result_data) {
    $error = mysqli_error($dbcon) . " " . __LINE__;
    empty_data($totalRecords, $error);
}

//IF CHECK OUT HOUR IS 00:00:00 THE USER FORGOT TO CHECK OUT SO HIS CHECK OUT TIME SHOULD BE 18:00:00
$updateCheckOutQuery = "UPDATE `checkins` SET `check_out_hour`='18:00:00' WHERE check_out_hour = '00:00:00'";

//EXECUTE QUERY
$exc_updateCheckOutQuery = mysqli_query($dbcon, $updateCheckOutQuery);

$data = array();

while ($row = mysqli_fetch_assoc($result_data)) {
    $data[$row['id']]['id'] = $row['id'];
    $data[$row['id']]['emri'] = $row['emri'];
    $data[$row['id']]['mbiemri'] = $row['mbiemri'];
    $data[$row['id']]['hours_in'] += $row['check_out_hour'] - $row['check_in_hour'];

    //HOURS OUT
    $data[$row['id']]['IN_HOURS_DATE'][$row['check_in_date']] += $row['check_out_hour'] - $row['check_in_hour'];
    $data[$row['id']]['details'][] = array("date" => $row['check_in_date'], "check_in_hour" => $row['check_in_hour'], "check_out_hour"=> $row["check_out_hour"]);

    //CHECK IF WORK HOURS BIGGER OR EQUAL THAN 8 THEN THE HOURS OUT = 0
    if ($data[$row['id']]['IN_HOURS_DATE'][$row['check_in_date']] >= 8) {
        $data[$row['id']]['OUT_HOURS_DATE'][$row['check_in_date']] = 0;
    } else {
        $data[$row['id']]['OUT_HOURS_DATE'][$row['check_in_date']] = 8 - $data[$row['id']]['IN_HOURS_DATE'][$row['check_in_date']];
    }

    //GET THE SUM FOR EACH HOURS OUT DATE
    $data[$row['id']]['hours_out'] = 0;
    foreach ($data[$row['id']]['OUT_HOURS_DATE'] as $date_check => $in_date) {
        $data[$row['id']]['hours_out'] += $in_date;
    }
}

foreach ($data as $key => $row) {
    $table_data[] = array("id" => $row['id'],
"actions" => '<button class="showDetails btn">+</button>',
    "emri" => $row['emri'],
    "mbiemri" => $row['mbiemri'],
    "hours_in" => $row['hours_in'],
    "hours_out" => $row['hours_out'],
    "details" => $row['details'],
    
);
}
    /**
     * DERGOJME TE DHENAT NE FRONTEND
     */
    $response = array("draw" => intval($draw), "iTotalRecords" => $totalRecords, "iTotalDisplayRecords" => $totalRecordwithFilter, "aaData" => $table_data);
    echo json_encode($response);
