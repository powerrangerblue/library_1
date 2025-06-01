<?php
$servername = "localhost";  // your DB host
$username = "root";         // your DB username
$password = "";             // your DB password
$dbname = "library_db";    // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
