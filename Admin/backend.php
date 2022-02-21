<?php
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'localweb' 
);// DB table to use 
$table = 'users'; 
 
// Table's primary key 
$primaryKey = 'id'; 

$columns = array( 
    array( 'db' => 'id', 'dt' => 0 ), 
    array( 'db' => 'emri',  'dt' => 2 ), 
    array( 'db' => 'mbiemri',      'dt' => 3 ), 
    array( 'db' => 'atesia',     'dt' => 4 ), 
    array( 'db' => 'nr_tel',    'dt' => 5 ),
    array( 'db' => 'email',    'dt' => 6 ),
    array( 'db' => 'datelindja',    'dt' => 7 ),
    array( 'db' => 'username',    'dt' => 8 ),
    array( 'db' => 'role',    'dt' => 9 ),
    array( 'db' => 'avatar',    'dt' => 10 ),
); 
require '../Includes/ssp.class.php'; 
 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
);
?>