<?php
	header('Access-Control-Allow-Origin: *');
	function getData()
	{

        $resumeID = $_GET['resumeID']; 
        //$resumeID = '4';

		//$current_user = wp_get_current_user();
        //$current_user = 'sam@jackson.com';
		$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
		if (!$link)
        {
			die('Could not connect: ' . mysql_error());
		}

		$db_selected = mysql_select_db('themaro0_dev1', $link);
		if (!$db_selected)
        {
			die('Cant use DB: ' . mysql_error());
		}


        //Acquire Basic Information
		$query = sprintf("SELECT resumeData from resume where resumeID='" . $resumeID . "'");
		$result = mysql_query($query); 
        if(!$result)
        {
            die('Could not query: ' . mysql_error());
        }

        
		while($row = mysql_fetch_assoc($result))
        {
            $basics = $row['resumeData'];  
		}


        //Print out JSON Objects
        echo $basics;
		mysql_close($link); 
	}

    getData();

?>