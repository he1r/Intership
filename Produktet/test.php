<?php
$dbcon = new mysqli("127.0.0.1", "root", "", "localweb");

$query_data = "SELECT product_categories.id,
product_categories.category_name,
product_categories.category_sasia,
products.product_sasia,
products.product_name,
products.product_price,
blerje.product_id,
blerje.sasia
FROM product_categories
INNER JOIN products ON product_categories.id = products.product_category_id
INNER JOIN blerje ON products.id = blerje.product_id;";

$query_result = mysqli_query($dbcon, $query_data);

$result_data = array();

while($row = mysqli_fetch_assoc($query_result)){

    $result_data[$row['id']]['id'] = $row['id'];
    $result_data[$row['id']]['category_name'] = $row['category_name'];
    $result_data[$row['id']]['category_stock'] = $row['category_sasia'];
    $result_data[$row['id']]['product_sold'] +=  $row['sasia'];
    $result_data[$row['id']]['xhiro'] += $row['sasia'] * $row['product_price'];
}

$query_outcome = "SELECT * From products where 1";

$query_outcome_result = mysqli_query($dbcon, $query_outcome);

while($row = mysqli_fetch_assoc($query_outcome_result)){
    $result_data[$row['product_category_id']]['shpenzim'] += $row['product_price'] * $row['product_sasia']; 
}