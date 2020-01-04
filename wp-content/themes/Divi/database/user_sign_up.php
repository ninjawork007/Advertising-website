<?php


$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wordpress/wp-config.php';
include_once $path . '/wordpress/wp-load.php';
include_once $path . '/wordpress/wp-includes/wp-db.php';

 
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
    case "email_check":
        $sql = "SELECT * FROM wp_customer WHERE email='" .$_POST['email']. "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo json_encode("already");
        } else {
            echo json_encode("new");
        }
        break;
    case "username_check":
        $sql = "SELECT * FROM wp_customer WHERE username='" .$_POST['username']. "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo json_encode("already");
        } else {
            echo json_encode("new");
        }
        break;
    case "register":
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $full_name = $_POST['fullname'];
        $sql = "INSERT INTO wp_customer ( username,  email, password, full_name, create_date) VALUES ( '".$username."', '".$email."', MD5('".$password."'), '".$full_name."', CURRENT_TIMESTAMP)"; 
        if ($conn->query($sql) === TRUE) {
            wp_redirect( site_url("/login/") );
        } else {
            echo "Error updating record: " . $conn->error;
        }
        break;
    case "logout":
        $_SESSION['user_id'] = NULL;
        echo json_encode("success");
        break;
}



$conn->close();
?>

  