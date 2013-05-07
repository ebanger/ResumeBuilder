<html>
<body>
<?php
if($_POST){
$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
if (!link) {
die('Could not connect: ' . mysql_error());
}
 
$db_selected = mysql_select_db('themaro0_dev1', $link);

if (!db_selected){
die('Cant use DB: ' . mysql_error());
}

$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$primaryPhone = $_POST['primaryPhone'];
$secondaryPhone = $_POST['secondaryPhone'];
$email = $_POST['email'];

$query = "INSERT INTO users(address1,address2, city, state, zip, phone1, phone2, email)VALUES('$address1','$address2', '$city','$state', '$zip','$primaryPhone', '$secondaryPhone','$email')";

mysql_query ($query);
mysql_close($link);
}
?>


<form method="post" action="<?php $_PHP_SELF ?>">
<p>
<strong>Street Address: </strong><br/>
<input type="text" name ="address1" maxlength="75" size="75" /> </br>
<input type="text" name ="address2" maxlength="75" size="75" />
</p>
    
<p><strong>City:</strong><br/>
<input type="text" name="city" maxlength="20" size="20" /> </br>
</p>
    
<p><strong>State:</strong><br/>
<input type="text" name="state" maxlength="2" size="2" /> </br>
</p><p><strong>Postal Code:</strong><br/>
<input type="text" name="zip" maxlength="6" size="6" /> </br>
</p>

<p><strong>Primary Phone:</strong><br/>
<input type="text" name="primaryPhone" maxlength="10" size="10" /> </br>
</p>

<p><strong>Secondary Phone:</strong><br/>
<input type="text" name="secondaryPhone" maxlength="10" size="10" /> </br>
</p>

<p><strong>Email Address:</strong><br/>
<input type="text" name="email" > </br>
</p>

<p><input type="submit" name = "Submit" value = "Submit"/></p>
</form>


</body>
</html>


