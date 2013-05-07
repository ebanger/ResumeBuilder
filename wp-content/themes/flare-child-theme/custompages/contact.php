<html>

<body>



<?php

	$current_user = wp_get_current_user();

	

	$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');

	if (!link){

		die('Could not connect: ' . mysql_error());

	}

	



	$db_selected = mysql_select_db('themaro0_dev1', $link);

	if (!db_selected){

		die('Cant use DB: ' . mysql_error());

	}

	$query = sprintf("SELECT userID from users where email='" . $current_user->user_login ."'");

	$result = mysql_query($query);

	$current_ID = mysql_result($result, 0);


	$query = sprintf("SELECT firstname, lastname, email, address1, address2, phone1, phone2, zip, city, state from users WHERE userID='" . $current_ID . "'");

	$result = mysql_query($query);



	while($row = mysql_fetch_assoc($result)){

		$firstname = $row['firstname'];

		$lastname =    $row['lastname'];

		$address1 	= $row['address1'];

		$address2	= $row['address2'];

		$email 		= $row['email'];

		$zip 	= $row['zip'];

		$city 		= $row['city'];

		$state 		= $row['state'];

        $phone1 = $row['phone1'];

    	$phone2 = $row['phone2']; 



		

	}



if($_POST){

$address1 = $_POST['address1'];

$address2 = $_POST['address2'];

$city = $_POST['city'];

$state = $_POST['state'];

$zip = $_POST['zip'];

$phone1 = $_POST['phone1'];

$phone2 = $_POST['phone2'];

$email = $_POST['email'];

$query = "UPDATE users SET address1 = '$address1', address2 = '$address2', city = '$city', state = '$state', zip = '$zip', phone1 = '$phone1', phone2 = '$phone2' WHERE userID = '$current_ID'";

mysql_query ($query);

mysql_close($link);

}

?>

















<form method="post" action="<?php $_PHP_SELF ?>">
<p><strong>Email Address:</strong><br/>
<input type="text" name="email" value=<?php echo "'" . $email . "'" ?> /> </br>
<p>
<strong>Street Address: </strong><br/>
<input type="text" name ="address1"  maxlength="75" size="75"  value=<?php echo "'" . $address1 . "'" ?> /> </br>
<input type="text" name ="address2" maxlength="75" size="75" value=<?php echo "'" . $address2 . "'" ?> />
</p>
    
<p><strong>City:</strong><br/>
<input type="text" name="city" maxlength="20" size="20" value=<?php echo "'" . $city . "'" ?> /> </br>
</p>
    
<p><strong>State:</strong><br/>
<input type="text" name="state" maxlength="2" size="2" value=<?php echo "'" . $state . "'" ?> /> </br>
</p><p><strong>Postal Code:</strong><br/>
<input type="text" name="zip" maxlength="6" size="6" value=<?php echo "'" . $zip . "'" ?> /> </br>
</p>

<p><strong>Primary Phone:</strong><br/>
<input type="text" name="phone1" maxlength="10" size="10" value=<?php echo "'" . $phone1 . "'" ?> /> </br>
</p>

<p><strong>Secondary Phone:</strong><br/>
<input type="text" name="phone2" maxlength="10" size="10" value=<?php echo "'" . $phone2 . "'" ?> /> </br>
</p>


</p>

<p><input type="submit" name = "Submit" value = "Submit"/></p>
</form>



</body>

</html>




