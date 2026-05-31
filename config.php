<?php
$host = "localhost";
$user = "root";   // XAMPP default
$pass = "";       // XAMPP default
$db   = "v2v_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
