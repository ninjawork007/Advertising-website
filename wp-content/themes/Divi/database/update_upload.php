<?php

$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads/ad_image';   //2
 
if (!empty($_FILES)) {

	$square_dir = $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-content/'. $storeFolder . '/';  //4
     
    $square_file = $square_dir . basename($_FILES["square"]["name"]);          //3  

    $uploadOk = 1;

	$squareImageType = strtolower(pathinfo($square_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["square"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	$square_filepath = '/wordpress/wp-content/'. $storeFolder . '/'. basename($_FILES["square"]["name"]); ;  //4
	move_uploaded_file($_FILES["square"]["tmp_name"], $square_file);

	$banner_dir = $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-content/'. $storeFolder . '/';  //4
     
    $banner_file = $banner_dir . basename($_FILES["banner_image"]["name"]);          //3 
    $banner_filepath = '/wordpress/wp-content/'. $storeFolder . '/'. basename($_FILES["banner_image"]["name"]);;  //4

    $uploadOk = 1;

	$squareImageType = strtolower(pathinfo($banner_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["banner_image"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	
	move_uploaded_file($_FILES["banner_image"]["tmp_name"], $banner_file);



    
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
	$campaign_type = $_POST['campaign_type'];
	$headline      = $_POST['headline'];
	$short_summary = $_POST['summary'];
	$ad_text       = $_POST['ad_text'];
	$business_name = $_POST['business_name'];
	$language      = $_POST['language'];
	$siteurl       = $_POST['site_url'];
	$id            = $_POST['id'];
	$square_image = '/wordpress/wp-content/'. $storeFolder . '/'. basename($_FILES["square"]["name"]); 
	$banner_image = '/wordpress/wp-content/'. $storeFolder . '/'. basename($_FILES["banner_image"]["name"]);
	$sql0 = "SELECT * FROM wp_customer_payment WHERE user_id='" .$user_id. "' ORDER BY id DESC";
    $result0 = $conn->query($sql0);
    $row = $result0->fetch_assoc();
    $o_square_image = '/wordpress/wp-content/'. $storeFolder . '/'. $row['square_image'];
    $o_banner_image = '/wordpress/wp-content/'. $storeFolder . '/'. $row['rectangle_image'];
	if ($square_image != '' && $banner_image != '') {
		$sql = "INSERT INTO wp_customer_payment ( card_id,  headline, short_summary, ad_text, business_name, language, siteurl, user_id, square_image, rectangle_image) VALUES ( '".$campaign_type."', '".$headline."', '".$short_summary."', '".$ad_text."','".$business_name."', '".$language."', '".$siteurl."', '".$user_id."', '".$square_image."', '".$banner_image."')";
	}
	if ($square_image == '' && $banner_image != '') {
		$sql = "INSERT INTO wp_customer_payment ( card_id,  headline, short_summary, ad_text, business_name, language, siteurl, user_id, square_image, rectangle_image) VALUES ( '".$campaign_type."', '".$headline."', '".$short_summary."', '".$ad_text."','".$business_name."', '".$language."', '".$siteurl."', '".$user_id."', '".$o_square_image."', '".$banner_image."')";
	}
	if ($square_image != '' && $banner_image == '') {
		$sql = "INSERT INTO wp_customer_payment ( card_id,  headline, short_summary, ad_text, business_name, language, siteurl, user_id, square_image, rectangle_image) VALUES ( '".$campaign_type."', '".$headline."', '".$short_summary."', '".$ad_text."','".$business_name."', '".$language."', '".$siteurl."', '".$user_id."', '".$square_image."', '".$o_banner_image."')";
	}
  	if ($square_image == '' && $banner_image == '') {
		$sql = "INSERT INTO wp_customer_payment ( card_id,  headline, short_summary, ad_text, business_name, language, siteurl, user_id, square_image, rectangle_image) VALUES ( '".$campaign_type."', '".$headline."', '".$short_summary."', '".$ad_text."','".$business_name."', '".$language."', '".$siteurl."', '".$user_id."', '".$o_square_image."', '".$o_banner_image."')";
	}		
        $result = $conn->query($sql);

        if($result === TRUE)
        	echo json_encode(array('upload_flag'=> $result));
        	wp_redirect(site_url('/map_update'));

    $conn->close();
}
?>     