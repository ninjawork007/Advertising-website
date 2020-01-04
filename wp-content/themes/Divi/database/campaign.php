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

switch ($_POST['func_check']) {
    case "campaign_card":
        $user_id = $_SESSION['user_id'];
        $card_id = $_POST['card_id'];
        $sql = "SELECT * FROM wp_customer_payment WHERE user_id='" .$user_id. "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $update_sql = "UPDATE wp_customer_payment SET card_id='".$card_id."' WHERE user_id='".$user_id."'";
            $update_result = $conn->query($update_sql);
            if($update_result === TRUE)
                echo json_encode("update");
            else
                echo json_encode("error");
        } else {
            $insert_sql = "INSERT INTO wp_customer_payment (user_id, card_id) VALUES ( '".$user_id."', '".$card_id."')";
            $insert_result = $conn->query($insert_sql);
            if($insert_result === TRUE)
                echo json_encode("insert");
            else
                echo json_encode("error");
        }
        
        break;
        case "campaign_get":
            $user_id = $_SESSION['user_id'];

            $sql = "SELECT * FROM wp_customer_payment WHERE user_id='" .$user_id. "' ORDER BY id DESC";
            $result = $conn->query($sql)->fetch_assoc();
            echo json_encode($result);
            break;
}



$conn->close();
?>

  