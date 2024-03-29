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

$email_filter = $_POST['email_filter'];
$phone_value = $_POST['phone_value'];
$datelindja_start_date = $_POST['datelindja_start_date'];
$datelindja_end_date = $_POST['datelindja_end_date'];

//IF THERES DATA FROM THE DATERANGE PICKER DATELINDJA FILTER
$datelindja_filter = '';

//CHECK IF THE START DATE AND END DATE ARE UNDEFINED
if($datelindja_start_date == "undefined"){
    $datelindja_start_date = "";
}
if($datelindja_end_date == "undefined"){
    $datelindja_end_date = "";
}
//IF START DATE AND END DATE ARE NOT UNDEFINED CREATE THE DATELINDJA FILTER QUERY
if ($datelindja_start_date != "" || $datelindja_end_date != "") {
    $datelindja_filter = "AND (datelindja BETWEEN '$datelindja_start_date' AND '$datelindja_end_date')";
}

//PHONE SELECT2 FILTER
$phone_filter = '';

//IF THERES DATA FROM SELECT2 CREATE THE QUERY FOR EACH VALUE
if (isset($_POST['phone_value']) && !empty($_POST['phone_value'])) {
    $phone_filter_array = explode(",",$_POST['phone_value']);

    $phone_filter = " AND nr_tel in ('".implode("','",$phone_filter_array)."')";
}

    //GET THE SEARCH VALUE DATA FROM THE TABLE
    $searchValue = mysqli_real_escape_string($dbcon, $_POST['search']['value']);
    //SEARCH QUERY STRING
    $searchQuery = "";

    //IF THERES A SEARCH VALUE INPUT FROM USER CREATE QUERY
    if ($searchValue != '') {
        $searchQuery = "AND (id LIKE '%" . $searchValue . "%' OR 	
        emri LIKE '%" . $searchValue . "%' OR
        mbiemri LIKE '%" . $searchValue . "%' OR 
        atesia LIKE '%" . $searchValue . "%' OR
        email LIKE '%" . $searchValue . "%' OR
        nr_tel LIKE '%" . $searchValue . "%' OR
        datelindja LIKE '%" . $searchValue . "%' OR
        username LIKE '%" . $searchValue . "%' OR
        role LIKE '%" . $searchValue . "%')";
    }

    if ($email_filter != "") {
        @$email_query = " AND (email LIKE '%" . $email_filter . "%')";
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

    @$query_with_ftl = "SELECT COUNT(*) AS allcount 
                   FROM  users
                   WHERE 
                   id LIKE '%" . $searchValue . "%' OR 	
                   emri LIKE '%" . $searchValue . "%' OR
                   mbiemri LIKE '%" . $searchValue . "%' OR 
                   atesia LIKE '%" . $searchValue . "%' OR
                   email LIKE '%" . $searchValue . "%' OR
                   nr_tel LIKE '%" . $searchValue . "%' OR
                   datelindja LIKE '%" . $searchValue . "%' OR
                   username LIKE '%" . $searchValue . "%' OR
                   role LIKE '%" . $searchValue . "%' 
                   $email_query
                   $phone_filter
                   $datelindja_filter
                   ";
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
    @$query_data = "SELECT id,
                      emri,
                      mbiemri,
                      atesia,
                      email,
                      nr_tel,
                      datelindja,
                      username,
                      role,
                      avatar
               FROM users where 1 = 1   
               $searchQuery $email_query $phone_filter $datelindja_filter ORDER BY  $columnName $columnSortOrder $pagination";

    $result_data = mysqli_query($dbcon, $query_data);
    if (!$result_data) {
        $error = mysqli_error($dbcon) . " " . __LINE__;
        empty_data($totalRecords, $error);
    }

    //VENDOSIM ALL ROWS NGA DATABASE NE NJE ARRAY
    $data = array();
    while ($row = mysqli_fetch_assoc($result_data)) {
        $data[$row['id']]['id'] = $row['id'];
        $data[$row['id']]['emri'] = $row['emri'];
        $data[$row['id']]['mbiemri'] = $row['mbiemri'];
        $data[$row['id']]['atesia'] = $row['atesia'];
        $data[$row['id']]['email'] = $row['email'];
        $data[$row['id']]['nr_tel'] = $row['nr_tel'];
        $data[$row['id']]['datelindja'] = $row['datelindja'];
        $data[$row['id']]['username'] = $row['username'];
        $data[$row['id']]['role'] = $row['role'];
        $data[$row['id']]['avatar'] = $row['avatar'];
    }
    /**
     * PERSHTASIM TE DHENAT SIPAS FORMATIT QE KERKOHET NE BACKEND
     */
    foreach ($data as $key => $row) {
        $table_data[] = array("id" => $row['id'],
    "actions" => '<div class="row"> <button class="edit_button btn" style="width: 30%; color:white; margin-left: 10%">Edit</button><button class= "admin_delete_user btn" style="width: 40%; color: white; margin-left:10%">Delete</button></div>',
        "emri" => $row['emri'],
        "mbiemri" => $row['mbiemri'],
        "atesia" => $row['atesia'],
        "email" => $row['email'],
        "nr_tel" => $row['nr_tel'],
        "datelindja" => $row['datelindja'],
        "username" => $row['username'],
        "role" => $row['role'],
        "avatar" => "<img class='userAvatar' style= 'width: 50px; height:50px;' src=" . $row['avatar']. ">"
        );
    }

    /**
     * DERGOJME TE DHENAT NE FRONTEND
     */
    $response = array("draw" => intval($draw), "iTotalRecords" => $totalRecords, "iTotalDisplayRecords" => $totalRecordwithFilter, "aaData" => @$table_data);
    echo json_encode($response);
?>