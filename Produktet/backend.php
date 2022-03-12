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
        $searchQuery = "AND (
        emri LIKE '%" . $searchValue . "%'
       )";
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
                   emri LIKE '%" . $searchValue . "%'
                
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
    $query_data = "SELECT
                      emri
               FROM users where 1 = 1   
               $searchQuery ORDER BY  $columnName $columnSortOrder $pagination";

    $result_data = mysqli_query($dbcon, $query_data);
    if (!$result_data) {
        $error = mysqli_error($dbcon) . " " . __LINE__;
        empty_data($totalRecords, $error);
    }

    //VENDOSIM ALL ROWS NGA DATABASE NE NJE ARRAY
    $data = array();
    while ($row = mysqli_fetch_assoc($result_data)) {
        $data[$row['id']]['emri'] = $row['emri'];
    }
    /**
     * PERSHTASIM TE DHENAT SIPAS FORMATIT QE KERKOHET NE BACKEND
     */
    foreach ($data as $key => $row) {
        $table_data[] = array(
    "actions" => '<button class="showProduktet"></button>',
        "emri" => $row['emri'],
        );
    }

    /**
     * DERGOJME TE DHENAT NE FRONTEND
     */
    $response = array("draw" => intval($draw), "iTotalRecords" => $totalRecords, "iTotalDisplayRecords" => $totalRecordwithFilter, "aaData" => $table_data);
    echo json_encode($response);
?>