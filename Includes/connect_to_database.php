<?php
$dbcon = new mysqli("localhost", "root", "", "test");
    if ($dbcon -> connect_errno) {
        echo "Failed to connect to MySQL: " . $dbcon -> connect_error;
        exit;
    }
?>
