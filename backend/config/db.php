<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "artists";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
}
?>