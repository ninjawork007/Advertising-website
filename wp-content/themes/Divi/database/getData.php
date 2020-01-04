<?php
/**
  ...
  147   * @since 2.0.0
  148   *
  149:  * @global wpdb $wpdb WordPress database abstraction object.
  150   *
  151   * @param array $linkdata Elements that make up the link to insert.
  ...
  154   */

$username = $_POST['user_id'];


$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wordpress/wp-config.php';
include_once $path . '/wordpress/wp-load.php';
include_once $path . '/wordpress/wp-includes/wp-db.php';

global $wpdb;

 		$contactus_table = $wpdb->prefix."payment";

      	$sql = "SELECT * FROM $contactus_table WHERE user_id='".$username."'"; 
            
        $result = $wpdb->get_results($sql); 
        echo json_encode($result[0]);
        // if($result == 1) {
          
        //   session_start();
        //   $_SESSION["user_id"] = $username;
        // 	wp_redirect( network_home_url() );
          

        // } else {
        //   wp_redirect( "http://localhost:8080/wordpress/user-account/" );
        // }
        // var_dump($result);die();
// var_dump( $wpdb->num_queries ); // total number of queries ran
// var_dump( $wpdb->num_rows ); // total number of rows returned by the last query
// var_dump( $wpdb->last_result ); // most recent query results
// var_dump( $wpdb->last_query ); // most recent query executed
// var_dump( $wpdb->col_info ); // column information for the most recent query
// $wpdb->show_errors();
?>