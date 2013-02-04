<?php
/* Prevent direct script access */
if ( !empty( $_SERVER[ 'SCRIPT_FILENAME' ] ) && 'functions.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'No direct script access allowed' );
}

function connect_to_db(){
 $current_user = wp_get_current_user();
 echo '**************[Test Data]********************<br />';
 echo 'Username: ' . $current_user->user_login . '<br />';
 echo 'User ID: ' . $current_user->ID . '<br />';

 $link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
 if (!link){
 	die('Could not connect: ' . mysql_error());
 }
 echo "Connected to SQL successfully...\n";

 $db_selected = mysql_select_db('themaro0_dev1', $link);
 if (!db_selected){
 	die('Cant use DB: ' . mysql_error());
 }

 $query = sprintf("SELECT firstname, lastname, email, password, address1, city, state, zip from users WHERE email='" . mysql_real_escape_string($current_user->user_login) . "'");
 $result = mysql_query($query);

 while($row = mysql_fetch_assoc($result)){
 	$firstname = $row['firstname'];
 	$lastname = $row['lastname'];
 	$email = $row['email'];
 	$password = $row['password'];
 	$address1 = $row['address1'];
 	$city = $row['city'];
 	$state = $row['state'];
 	$zip	 = $row['zip'];
 	echo $email;
 	echo "|";
 	echo $password;
 	echo "|";
 	echo $address1;

 }
  mysql_close($link);
 echo '<br />***********************************************<br />';
}

function get_name(){
	return $firstname;
}

function get_lastname(){
	return $lastname;
}

function get_email(){
	return $email;
}
/**
* Flare Child Theme Setup
* 
* Always use child theme if you want to make some custom modifications. 
* This way theme updates will be a lot easier.
*/
function btp_flarechild_setup() {
	
	
	
}
add_action( 'after_setup_theme', 'btp_flarechild_setup' );
?>