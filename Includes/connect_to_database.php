<?php
$dbcon = new mysqli("127.0.0.1", "root", "", "localweb");
    if ($dbcon -> connect_errno) {
        echo "Failed to connect to MySQL: " . $dbcon -> connect_error;
        exit;
    }
?>