<?php
// db.php
$host = 'localhost';
$dbname = 'boycott_israel';
$username = 'root';
$password = '';

// Create connection
$mysqli = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
