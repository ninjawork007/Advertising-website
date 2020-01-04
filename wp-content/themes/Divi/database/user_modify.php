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
            echo json_encode(array('state'=>'success','data'=>$result->fetch_assoc()));
        } else {
            echo json_encode(array('state'=>'failed','data'=>array()));
        }
        break;
    
    case "modify":
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $full_name = $_POST['fullname'];
        $id = $_POST['id'];
        $sql = "UPDATE wp_customer SET username='".$username."',password=MD5('".$password."'),full_name='".$full_name."', update_date=CURRENT_TIMESTAMP, email='".$email."' WHERE id='".$id."'"; 
        if ($conn->query($sql) === TRUE) {
            wp_redirect( "http://localhost:8080/wordpress/login/" );
        } else {
            echo "Error updating record: " . $conn->error;
        }
        break;
    
}



$conn->close();
?>


        