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
    case "get_user_card":
        $sql = "SELECT * FROM wp_customer_payment WHERE user_id='" .$user_id. "' ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
             	$sql2 = "SELECT * FROM wp_card WHERE id='" .$row['card_id']. "'";
             	 $result2 = $conn->query($sql2)->fetch_assoc();
                    echo json_encode($result2);
        } else {
            echo json_encode("new");
        }
        break;
    case "get_user_data":
        $sql = "SELECT * FROM wp_customer_payment WHERE user_id='" .$user_id. "' ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                $sql2 = "SELECT * FROM wp_card WHERE id='" .$row['card_id']. "'";
                 $result2 = $conn->query($sql2)->fetch_assoc();
                $sql3 = "SELECT * FROM wp_ad_location WHERE user_id='" .$user_id. "' ORDER BY id DESC";
                 $result3 = $conn->query($sql3)->fetch_assoc();
                    echo json_encode(array('card'=>$result2, 'location'=>$result3));
        } else {
            echo json_encode("new");
        }
        break;
    case "save_map":
    	$lon_lat = $_POST['lon_lat'];
    	$address = $_POST['address'];
    	$radius  = $_POST['radius'];
        $sql = "INSERT INTO wp_ad_location ( user_id,  lon_lat, address, radius) VALUES ( '".$user_id."', '".$lon_lat."', '".$address."', '".$radius."')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode("success");
        } else {
            echo json_encode("error");
        }
        break;
    case "update_map":
        $lon_lat = $_POST['lon_lat'];
        $address = $_POST['address'];
        $radius  = $_POST['radius'];
        $id      = $_POST['id'];
        $sql = "UPDATE wp_ad_location SET lon_lat='".$lon_lat."', address='".$address."', radius= '".$radius."' WHERE user_id = '".$user_id."' AND id='".$id."'";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode("success");
        } else {
            echo json_encode("error");
        }
        break;
    case 'get_user_all_data':
        $result = array();
        $location_sql = "SELECT * FROM wp_ad_location WHERE user_id='".$_SESSION['user_id']."'";
        $result1 = $conn->query($location_sql);
        $locations = array();
        while ($row1 = $result1->fetch_assoc()) {
            array_push($locations, $row1);
        }
        $result['locations'] = $locations;
        $schedule_sql = "SELECT * FROM wp_schedule WHERE user_id='".$_SESSION['user_id']."'";
        $result2 = $conn->query($schedule_sql);
        $schedules = array();
        while ($row2 = $result2->fetch_assoc()) {
            array_push($schedules, $row2);
        }
        $result['schedules'] = $schedules;
        $payment_sql = "SELECT * FROM wp_customer_payment WHERE user_id='".$_SESSION['user_id']."'";
        $result3 = $conn->query($payment_sql);
        $payments = array();
        while ($row3 = $result3->fetch_assoc()) {
            array_push($payments, $row3);
        }
        $result['payments'] = $payments;
        $card_sql = "SELECT * FROM wp_card";
        $result4 = $conn->query($card_sql);
        $cards = array();
        while ($row4 = $result4->fetch_assoc()) {
            array_push($cards, $row4);
        }
        $result['cards'] = $cards;
        echo json_encode($result);
        break;
}



$conn->close();
?>

