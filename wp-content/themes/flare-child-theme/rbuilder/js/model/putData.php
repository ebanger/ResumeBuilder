<?php

    $stringData = $_POST['resume']; 

    //SETUP SQL LINK//
    $current_user = 'sam@jackson.com';
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



	//Write the data to SQL//

	if(is_null($stringData))
	{
		echo "No data to write";
	}
	else
	{
		$query = sprintf("INSERT INTO resume (userID, resumeData) VALUES ('2', '" . json_encode($stringData) . "')");
		$result = mysql_query($query); 
	    if(!$result)
	    {
	        die('Could not query: ' . mysql_error());
	    }
	}

    mysql_close($link);
?>