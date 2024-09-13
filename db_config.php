<?php
$serverName = "DESKTOP-9RMQ4K2";
$connectionOptions = array(
    "Database" => "bio_shop",
    "Uid" => "", // Your database username
    "PWD" => ""  // Your database password
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
