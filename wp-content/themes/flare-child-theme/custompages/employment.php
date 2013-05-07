<html>



<body>



<?php



$current_user = wp_get_current_user();



$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');



if (!link) {

	die('Could not connect: ' . mysql_error());

}



$db_selected = mysql_select_db('themaro0_dev1', $link);


if (!db_selected){

	die('Cant use DB: ' . mysql_error());

}

$query = sprintf("SELECT userID from users where email='" . $current_user->user_login ."'");

$result = mysql_query($query);

$current_ID = mysql_result($result, 0);

$query = sprintf("SELECT companyName, jobTitle, city, state, beginDate, endDate, achievements, reason  from employment WHERE userID='" . $current_ID . "'");

$result = mysql_query($query);



while($row = mysql_fetch_assoc($result)){

		$company = $row['companyName'];

		$title =    $row['jobTitle'];

		$city = $row['city'];

		$state = $row['state'];

		$beginDate 	= $row['beginDate'];

		$endDate	= $row['endDate'];

		$achievements = $row['achievements'];

		$reason = $row['reason'];
	}





if($_POST){

$company = $_POST['company'];

$title = $_POST['title'];

$city = $_POST['city'];

$state = $_POST['state'];

$beginDate = $_POST['beginDate'];

$endDate = $_POST['endDate'];

$achievements = $_POST['achievements']; 

$reason = $_POST['reason'];

$query = sprintf("SELECT * from employment where userID='" . $current_ID ."'");

$result = mysql_query($query);

$num = mysql_num_rows($result);

if($num > 0){
	$query = "UPDATE employment SET companyName = '$company', jobTitle = '$title', city = '$city', state = '$state', beginDate = '$beginDate', endDate = '$endDate', achievements = '$achievements', reason = '$reason' WHERE userID = '$current_ID'";
} elseif($num == 0) {
	$query = "INSERT INTO employment(userID, companyName, jobTitle, city, state, beginDate, endDate, achievements, reason)VALUES('$current_ID', '$company', '$title', '$city', '$state', '$beginDate', '$endDate','$achievements', '$reason')";
}

mysql_query ($query);

mysql_close($link);

}

?>



<form method="post" action="<?php $_PHP_SELF ?>">

    

<p><strong>Company: </strong><br/>

<input type="text" name ="company" maxlength="75" size="75" value=<?php echo "'" . $company . "'" ?> /> </br>

</p>



<p><strong>Title:</strong><br/>

<input type="text" name="title" maxlength="30" size="30" value=<?php echo "'" . $title . "'" ?> /> </br>

</p>

    

<p><strong>City:</strong><br/>

<input type="text" name="city" maxlength="20" size="20" value = <?php echo "'" . $city . "'"?> /> </br>

</p>

<p><strong>State:</strong><br/>

<input type="text" name="state" maxlength="20" size="20" value = <?php echo "'" . $state . "'" ?> /> </br>

</p>



<br/>

<p><strong>Begin Date (YYYY-MM-DD): </strong><br/>

<input type="text" name ="beginDate" value=<?php echo "'" . $beginDate . "'" ?> maxlength="30" style="width:150px" /> </br>

</p>

<p><strong>End Date (YYYY-MM-DD): </strong><br/>

<input type="text" name ="endDate" value=<?php echo "'" . $endDate . "'" ?> maxlength="30" style="width:150px" /> </br>

</p>


<p><strong>Achievements: </strong><br/>

<input type="text" name ="achievements" value=<?php echo "'" . $achievements . "'" ?> maxlength="100" style="width: 500px; height:100px; " /> </br>

</p>



<p><strong>Reason for Leaving: </strong><br/>

<input type="text" name ="reason" maxlength="100" size="100" value=<?php echo "'" . $reason . "'" ?> /> </br>

</p>





<br/>

<p><input type="submit" value = "Submit"/></p>

</form>



</body>

</html>

