<?php
$host = "sql103.infinityfree.com"; // FROM InfinityFree panel → MySQL Hostname
$user = "if0_39565221";    // your InfinityFree username
$pass = "mBJjpr821ppq";    // your InfinityFree DB password
$dbname = "if0_39565221_clinic_db"; // your full database name

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
