<?php

/*
 * Template Name: Edit Profile
 *
 */

?>

<form>

<?php
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

	$query = sprintf("SELECT firstname, lastname, email, password, address1, city, state from users WHERE email='" . mysql_real_escape_string($current_user->user_login) . "'");
	$result = mysql_query($query);

	while($row = mysql_fetch_assoc($result)){
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		echo $email;
		echo "|";
		echo $row['password'];
		echo "|";
		$address1 = $row['address1'];
		echo $address1;
		$city = $row['city'];
		$state = $row['state'];
	}
	mysql_close($link);
	echo '<br />***********************************************<br />';
?>
<div class="field-group-1">
<div class="fcol col-label-1">First Name:</div>
<div class="fcol col-tip">?</div>
<div class="fcol col-input-1"><input type="text" name="firstname" value=<?php echo $firstname; ?> /> </div>
</div>

<div class="field-group-1">
<div class="fcol col-label-1">Middle Name:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="middlename" /> </div>
</div>

<div class="newrow"></div>

<div class="field-group-1">
<div class="fcol col-label-1">Last Name:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="lastname" value=<?php echo $lastname; ?> /> </div>
</div>


<div class="row-divider"></div>

<div class="field-group-1">
<div class="fcol col-label-1">Street Address:</div>
<div class="fcol col-tip">?</div>
<div class="fcol col-input-1"><input type="text" name="Streetline1" value=<?php echo $address1; ?>  /></div>
<div class="newrow"></div>
<div class="fcol col-label-1"></div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="Streetline1" /></div>
</div>


<div class="field-group-1">
<div class="fcol col-label-1">State:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="State" value=<?php echo $state; ?> /> </div>
<div class="newrow"></div>
<div class="fcol col-label-1">Country:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="Country" /> </div>
</div>

<div class="newrow"></div>

<div class="field-group-1">
<div class="fcol col-label-1">City:</div>
<div class="fcol col-tip">?</div>
<div class="fcol col-input-1"><input type="text" name="city" value=<?php echo $city; ?> /> </div>
</div>

<div class="field-group-1">
<div class="fcol col-label-1">Postal Code:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="postalcode" /> </div>
</div>

<div class="row-divider"></div>

<div class="field-group-1">
<div class="fcol col-label-1">Primary Phone:</div>
<div class="fcol col-tip">?</div>
<div class="fcol col-input-1"><input type="text" name="primaryphone" /> </div>
</div>

<div class="field-group-1">
<div class="fcol col-label-1">Phone Type:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="primaryphonetype" /> </div>
</div>

<div class="newrow"></div>

<div class="field-group-1">
<div class="fcol col-label-1">Secondary Phone:</div>
<div class="fcol col-tip">?</div>
<div class="fcol col-input-1"><input type="text" name=secondaryphone" /> </div>
</div>

<div class="field-group-1">
<div class="fcol col-label-1">Phone Type:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="secondaryphonetype" /> </div>
</div>

<div class="newrow"></div>

<div class="field-group-1">
<div class="fcol col-label-1">Email Address:</div>
<div class="fcol col-tip">?</div>
<div class="fcol col-input-1"><input type="text" name=email" /> </div>
</div>


<div class="field-group-1">
<div class="fcol col-label-1">Website:</div>
<div class="fcol col-tip"></div>
<div class="fcol col-input-1"><input type="text" name="website" /> </div>
</div>

<div class="newrow"></div>
<p></p>
<div style="float:right;">[button link="/education/" size="medium"]Next[/button]</div>
<div class="newrow"></div>

</form>