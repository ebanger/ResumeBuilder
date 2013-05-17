<?php
	header('Access-Control-Allow-Origin: *');

    $stringData = $_POST['resume']; 
    $current_user = $_POST['currentUser'];
    //SETUP SQL LINK//
    
    //$current_dude = wp_get_current_user();

    

	$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
	if (!link)
    {
		die('Could not connect: ' . mysql_error());
	}

	$db_selected = mysql_select_db('themaro0_dev1', $link);
	if (!$db_selected)
    {
		die('Cant use DB: ' . mysql_error());
	}
	
	$query = sprintf("SELECT userID from users where email='" . $current_user ."'");
    $result = mysql_query($query);

    $current_ID = mysql_result($result, 0);


	//Write the data to SQL//

	if(is_null($stringData))
	{
		echo "No data to write";
	}
	else
	{
		$query = sprintf("INSERT INTO resume (userID, resumeData) VALUES ('$current_ID', '" . json_encode($stringData) . "')");
		$result = mysql_query($query); 
	    if(!$result)
	    {
	        die('Could not query: ' . mysql_error());
	    }
	}

	// Make new resumeID current resumeID for user.
	$query = sprintf("SELECT resumeID FROM resume WHERE resumeData = '" . json_encode($stringData) ."' ");

	$result = mysql_query($query);

	$currentResumeId = mysql_result($result, 0);

	$query = sprintf("UPDATE users SET currentResume = '$currentResumeId' WHERE userID = '$current_ID'");

	mysql_query($query);

    mysql_close($link);
?>
