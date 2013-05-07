<?php
    header('Access-Control-Allow-Origin: *');
	function getData()
	{
		$current_user = wp_get_current_user();
        

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

        $query = sprintf("SELECT userID from users where email='" . $current_user->user_login ."'");
        $result = mysql_query($query);

        $current_ID = mysql_result($result, 0);

        //Acquire Resume List
		$query = sprintf("SELECT resumeID from resume WHERE userID='" . $current_ID . "'");
		$result = mysql_query($query); 
        if(!$result)
        {
            die('Could not query: ' . mysql_error());
        }

        $resumeList = array();
        while($r = mysql_fetch_assoc($result))
        {
            $resumeList[] = $r;
        }


        #$subResume = array_merge($education,$employment);
        #$currentResume = array('currentResume'=>$subResume);
        $resumeList = array('resumes'=>$resumeList);

        //Print out JSON Objects
        echo json_encode($resumeList);
		mysql_close($link); 
	}

    getData();

?>