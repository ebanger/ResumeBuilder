<?php
	
	function getData()
	{

		//$current_user = wp_get_current_user();
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


        //Acquire Basic Information
		$query = sprintf("SELECT firstname, lastname, userID, address1 from users WHERE email='" . $current_user . "'");
		$result = mysql_query($query); 
        if(!$result)
        {
            die('Could not query: ' . mysql_error());
        }

        
		while($row = mysql_fetch_assoc($result))
        {
            $basics = array ('name'=>$row['firstname'] . " " . $row['lastname'], 'userID'=>$row['userID'],
             'street'=>$row['address1']);  
		}

        $current_ID = $basics['userID'];

        //Acquire Education Information//
        $query = sprintf("SELECT educationID, schoolName, gpa from education where userID='" . $current_ID . "'");
        $result = mysql_query($query);
        if(!result)
        {
            die('Could not query: ' . mysql_error());
        }

        $edu = array();
        while($r = mysql_fetch_assoc($result))
        {
            $edu[] = $r;
        }

        //Acquire Employment Information//
        $query = sprintf("SELECT companyName, jobTitle, beginDate from employment where userID='" . $current_ID . "'");
        $result = mysql_query($query);
        if(!result)
        {
            die('Could not query: ' . mysql_error());
        }

        $emp = array();
        while($r = mysql_fetch_assoc($result))
        {
            $emp[] = $r;
        }



        $education = array('education'=>$edu);
        $employment = array('employment'=>$emp);
        $subResume = array_merge($education,$employment);
        $currentResume = array('currentResume'=>$subResume);
        $basics = array_merge($basics, $currentResume);

        //Print out JSON Objects
        echo json_encode($basics);
		mysql_close($link); 
	}

    getData();

?>