<?php
$dbcon = new mysqli("localhost", "root", "", "test_paga");
    if ($dbcon -> connect_errno) {
        echo "Failed to connect to MySQL: " . $dbcon -> connect_error;
        exit;
    }
?>
