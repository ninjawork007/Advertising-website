<?php

$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wordpress/wp-config.php';
include_once $path . '/wordpress/wp-load.php';
include_once $path . '/wordpress/wp-includes/wp-db.php';


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airs_db";
session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM wp_customer WHERE username = '" . $_POST['username'] . "' AND  password =  MD5('".$_POST['password']."') ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
   while($row = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $row['id'];
     wp_redirect( site_url("/campaign/") );
   }
} else {
    echo "Error user login: " . $conn->error;
}

$conn->close();
?>