<?php

$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wordpress/wp-config.php';
include_once $path . '/wordpress/wp-load.php';
include_once $path . '/wordpress/wp-includes/wp-db.php';
session_start();
$user_id = $_SESSION['user_id'];

 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airs_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

switch ($_POST['func_check']) {
    
    case "save_schedule":
    	$ad_schedule = $_POST['ad_schedule'];
    	$ad_ages = $_POST['ad_ages'];
    	$ad_genders  = $_POST['ad_genders'];
        $interest= $_POST['interest'];
        $ad_schedule = json_encode($ad_schedule);
        $ad_ages = json_encode($ad_ages);
        $ad_genders = json_encode($ad_genders);
        $sql = "INSERT INTO wp_schedule ( user_id,  ad_schedule, ad_ages, ad_genders, interest) VALUES ( '".$user_id."', '".$ad_schedule."', '".$ad_ages."', '".$ad_genders."', '".$interest."')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode("success");
        } else {
            echo json_encode("error");
        }
        break;
    case "get_schedule":
        
        $sql = "SELECT * FROM wp_schedule WHERE user_id='".$user_id."' ORDER BY id DESC";
        
        $result = $conn->query($sql)->fetch_assoc();
        echo json_encode($result);
        break;
    case "show_confirm" :
        $sql = "SELECT * FROM wp_customer_payment WHERE user_id='".$user_id."' ORDER BY id DESC";
        $result = $conn->query($sql)->fetch_assoc();
        echo json_encode($result);
}



$conn->close();
?>

