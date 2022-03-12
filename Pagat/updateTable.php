<?php

include "../Includes/connect_to_pagat_database.php";

/**
 * GET ALL THE DATA FROM THE TABLE
 */
$draw = $_POST['draw'];
$limit_start = $_POST['start'];
$limit_end = $_POST['length'];
$columnIndex = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir'];

//CHECK IF THE DATE IS WEEKEND OR NOT
function isWeekend($date)
{
    $weekDay = date('w', strtotime($date));
    return ($weekDay == 0 || $weekDay == 6);
}

//QUERY TO GET ALL THE OFFDAYS
$off_days_query = "SELECT date FROM off_days";

//EXECUTE QUERY
$execute_off_days_query = mysqli_query($dbcon, $off_days_query);

if (!$execute_off_days_query) {
    echo mysqli_error($dbcon)." ".__LINE__;
    exit;
}
//ARRAY THAT CONTAINS EVERY OFF DATE
$off_days_array = array();

while ($row = mysqli_fetch_assoc($execute_off_days_query)) {
    $off_days_array[$row["date"]] = $row['date'];
}

    //GET THE SEARCH VALUE DATA FROM THE TABLE
    $searchValue = mysqli_real_escape_string($dbcon, $_POST['search']['value']);
    //SEARCH QUERY STRING
    $searchQuery = "";

    //IF THERES A SEARCH VALUE INPUT FROM USER CREATE QUERY
    if ($searchValue != '') {
        $searchQuery = "AND (users.id LIKE '%" . $searchValue . "%' OR 	
        full_name LIKE '%" . $searchValue . "%')";
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
                    FROM users
                   WHERE 
                   id LIKE '%" . $searchValue . "%' OR 	
                   full_name LIKE '%" . $searchValue . "%'
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
    $query_users_data = "SELECT 
    users.id,
    full_name,
    total_paga,
    date,
    hours
    FROM working_days 
    left join users ON working_days.user_id = users.id;";

$result_users_data = mysqli_query($dbcon, $query_users_data);

if (!$result_users_data) {
    echo mysqli_error($dbcon)." ".__LINE__;
    exit;
}

//ALL DATA
$users_data = array();

while ($row = mysqli_fetch_assoc($result_users_data)) {

// Te dhenat e userit
    $users_data[$row['id']]['id'] = $row['id'];
    $users_data[$row['id']]['full_name'] = $row['full_name'];

    // // llogarisim pagen per ore
    $pagaPerHour = $row['total_paga'] / 22 / 8;
    $users_data[$row['id']]['payment_per_hour'] = round($pagaPerHour, 2);

    // Llogarisim oret brenda dhe jashte orarit
    $in_hours = $row['hours'];
    $out_hours = 0;

    if ($row['hours'] > 8) {
        $in_hours = 8;
        $out_hours = $row['hours'] - 8;
    }

    $users_data[$row['id']]['in_hours'] += $in_hours;
    $users_data[$row['id']]['out_hours'] += $out_hours;
    $users_data[$row['id']]['total_hours'] += $row['hours'];


    // Llogarisim pagesen qe i takon per cdo dite
    // Shohim fillimisht nese eshte dite festive
    if (isset($off_days[$row['date']])) {
        //NQFS DATA ESHTE DITE PUSHIM ATHERE ORE_IN_PUSHIM DHE ORE_OUT_PUSHIM = ME VLEREN E IN HOURS DHE OUT HOURS TE KESAJ DATE
        $users_data[$row['id']]['ore_in_pushim'] += $in_hours;
        $users_data[$row['id']]['oret_out_pushim'] += $out_hours;
        $users_data[$row['ore_in_pushim_total']] += $in_hours;
        $users_data[$row['ore_out_pushim_total']] += $out_hours;
        // percaktojme koefincentet per brenda orarit dhe jashte orarit
        $k_in_hours = 1.5;
        $k_out_hours = 2;
        $users_data[$row['id']]['paga_in_pushim'] += $users_data[$row['id']]['payment_per_hour'] * $in_hours * $k_in_hours;
        $users_data[$row['id']]['paga_out_pushim'] += $users_data[$row['id']]['payment_per_hour'] * $out_hours * $k_out_hours;

    } elseif (isWeekend($row['date'])) {
        //NQFS DATA ESHTE DITE FUNDJAVE ATHERE ORE_IN_PUSHIM DHE ORE_OUT_PUSHIM = ME VLEREN E IN HOURS DHE OUT HOURS TE KESAJ DATE
        $users_data[$row['id']]['ore_in_weekend'] += $in_hours;
        $users_data[$row['id']]['oret_out_weekend'] += $out_hours;
        // percaktojme koefincentet per brenda orarit dhe jashte orarit
        $k_in_hours = 1.25;
        $k_out_hours = 1.5;
        $users_data[$row['id']]['paga_in_weekend'] +=  $users_data[$row['id']]['payment_per_hour'] * $in_hours * $k_in_hours;
        $users_data[$row['id']]['paga_out_weekend'] += $users_data[$row['id']]['payment_per_hour'] * $out_hours * $k_out_hours;

    } else {
        //NQFS DATA ESHTE DITE PUNE ATHERE ORE_IN_PUSHIM DHE ORE_OUT_PUSHIM = ME VLEREN E IN HOURS DHE OUT HOURS TE KESAJ DATE
        $users_data[$row['id']]['ore_in_normal'] += $in_hours;
        $users_data[$row['id']]['oret_out_normal'] += $out_hours;
        // percaktojme koefincentet per brenda orarit dhe jashte orarit
        $k_in_hours = 1;
        $k_out_hours = 1.25;
        $users_data[$row['id']]['paga_in_normal'] +=  $users_data[$row['id']]['payment_per_hour'] * $in_hours * $k_in_hours;
        $users_data[$row['id']]['paga_out_normal'] += $users_data[$row['id']]['payment_per_hour'] * $out_hours * $k_out_hours;

    }

    // Llogaritja e pages totale, pages in hours dhe paga out of hours
    $users_data[$row['id']]['totale_payment_in_hours'] += $users_data[$row['id']]['payment_per_hour'] * $in_hours * $k_in_hours;
    $users_data[$row['id']]['totale_payment_out_hours'] += $users_data[$row['id']]['payment_per_hour'] * $out_hours * $k_out_hours;
    $users_data[$row['id']]['totale_payment'] += $users_data[$row['id']]['payment_per_hour'] * $in_hours * $k_in_hours + $users_data[$row['id']]['payment_per_hour'] * $out_hours * $k_out_hours;

    // Llogaritja per date e pages totale, pages in hours dhe paga out of hours
    $users_data[$row['id']]['Cal_For_DATE'][$row['date']]['payment_in_hurs'] += $users_data[$row['id']]['payment_per_hour'] * $in_hours * $k_in_hours;
    $users_data[$row['id']]['Cal_For_DATE'][$row['date']]['payment_out_hours'] += $users_data[$row['id']]['payment_per_hour'] * $out_hours * $k_out_hours;
    $users_data[$row['id']]['Cal_For_DATE'][$row['date']]['totale_payment'] += $users_data[$row['id']]['payment_per_hour'] * $in_hours * $k_in_hours + $users_data[$row['id']]['payment_per_hour'] * $out_hours * $k_out_hours;

    $users_data[$row['id']]['Cal_For_DATE'][$row['date']]['data'] = $row['date'];
    $users_data[$row['id']]['Cal_For_DATE'][$row['date']]['in_hours'] = $in_hours;
    $users_data[$row['id']]['Cal_For_DATE'][$row['date']]['out_hours'] = $out_hours;
    $users_data[$row['id']]['Cal_For_DATE'][$row['date']]['total_hours'] = $in_hours + $out_hours;
}
    /**
     * PERSHTASIM TE DHENAT SIPAS FORMATIT QE KERKOHET NE BACKEND
     */

    foreach ($users_data as $key => $row) {
        $table_data[] = array(
        "actions" => '<button class="showPagatDetails btn">+</button>',
        "full_name" => $row['full_name'],
        "ore_in_pushim" =>  $row['ore_in_pushim'],
        "ore_in_weekend" => $row['ore_in_weekend'],
        "ore_in_normal" =>$row['ore_in_normal'], 
        "oret_in" => $row['in_hours'], 
        "ore_out_pushim" => $row['oret_out_pushim'],
        "ore_out_weekend" => $row['oret_out_weekend'],
        "ore_out_normal" => $row['oret_out_normal'],
        "oret_out" => $row['out_hours'],
        "oret_total" => $row["total_hours"],
        "paga_total" => round($row['totale_payment'], 2),
        "paga_in_pushim" => round($row['paga_in_pushim'], 2),
        "paga_in_weekend" => round($row['paga_in_weekend'], 2),
        "paga_in_normal" => round($row['paga_in_normal'], 2),
        "paga_total_in_hours" => round($row["totale_payment_in_hours"], 2),
        "paga_out_pushim" => round($row['paga_out_pushim'], 2),
        "paga_out_weekend" => round($row['paga_out_weekend'], 2),
        "paga_out_normal" => round($row['paga_out_normal'], 2),
        "paga_total_out_hours" => round($row["totale_payment_out_hours"], 2),
        "details" => $row['Cal_For_DATE']
        );
    }

    /**
     * DERGOJME TE DHENAT NE FRONTEND
     */
    $response = array("draw" => intval($draw), "iTotalRecords" => $totalRecords, "iTotalDisplayRecords" => $totalRecordwithFilter, "aaData" => $table_data);
    echo json_encode($response);
