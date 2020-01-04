<?php
@session_start();


    $username = $_SESSION['user'];

    $headline = $_POST['headline'];
    $short_summary = $_POST['short_summary'];
    $ad_text = $_POST['ad_text'];
    $business_name = $_POST['business_name'];

	$path = $_SERVER['DOCUMENT_ROOT'];

    include_once $path . '/wordpress/wp-config.php';
	include_once $path . '/wordpress/wp-load.php';
	include_once $path . '/wordpress/wp-includes/wp-db.php';

	global $wpdb;

	 		$contactus_table = $wpdb->prefix."payment";

	      		$sql = "UPDATE $contactus_table SET 
								      		headline='".$headline."',
								      		short_summary='".$short_summary."', 
								      		ad_text='".$ad_text."',
								      		business_name='".$business_name."'
								      		 		WHERE user_id='".$username."'";
	        $result = $wpdb->query($sql); 
 
     		if($result == 1)
     			echo json_encode('success');  
?>     