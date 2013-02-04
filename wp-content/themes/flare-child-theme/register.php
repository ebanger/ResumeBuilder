<?php
/*
Template Name: Signup
*/
require_once(ABSPATH . WPINC . '/registration.php');
global $wpdb;
//Check whether the user is already logged in
if (!is_user_logged_in()) {
	if($_POST){
		//SQL escape all inputs
		$firstname = $wpdb->escape($_REQUEST['fname']);
		$lastname = $wpdb->escape($_REQUEST['lname']);

		$email = $wpdb->escape($_REQUEST['email']);
		if(empty($email)) {
			echo "Email should not be empty.";
			exit();
		}

		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
			echo "Please enter a valid email.";
			exit();
		}

		$password = $wpdb->escape($_REQUEST['password']);

		// Connect to own database
		$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
		if (!link) {
			die('Could not connect: ' . mysql_error());
		}

		$db_selected = mysql_select_db('themaro0_dev1', $link);
		if (!db_selected){
			die('Cant use DB: ' . mysql_error());
		}

		
		$sSql = "INSERT INTO users (email, firstname, lastname) 
					VALUES ('" . $email . "', '" . $firstname . "', '" . $lastname . "')";
	
		mysql_query($sSql);

		mysql_close($link);

		// Register email and password into Wordpress's database
		$status = wp_create_user($email, $password);
		if ( is_wp_error($status) )
			echo "Username already exists. Please try another one.";
		else {
			echo "Registration Successfully";
		}
		exit();

	} else {
		get_header();
?>

<div id ="container">
<div id = "content">

<?php if(get_option('users_can_register')) { 
//Check whether user registration is enabled by the administrator 
?>

<div id="result"></div> <!-- To hold validation results -->  
Please enter information to register your account
<form method ="post" action = "">

<p><strong>First name:</strong><br/>
<input type="text" name="fname"/></p>

<p><strong>Last name:</strong><br/>
<input type="text" name="lname"/></p>

<p><strong>Email:</strong><br/>
<input type="text" name="email"/></p>

<p><strong>Password:</strong><br/>
<input type="password" name="password"/></p>

<p><input type="submit" name="submit" value="Register"/></p>
</form>


<?php } else echo "Registration is currently disabled. Please try again later."; ?>

</div>
</div>
<?php

    //get_footer();
 } //end of if($_post)

}
else {
    wp_loginout( home_url() ); // Display "Log Out" link.
    echo " | ";
    wp_register('', ''); // Display "Site Admin" link.
}
?>
