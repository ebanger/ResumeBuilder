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

        //Print out JSON Objects
        echo json_encode($basics);
        //echo "var testjson = " . json_encode($basics) . ";";
        //echo json_encode($edu);
		mysql_close($link); 
	}

    getData();

/*
                name: 'John Doe',
                userID: 1,
                resumeID: 1,
                street: '123 Street St.',
                education: [
                    {
                        educationID: '1', 
                        schoolName: 'ASU',
                        gpa: 3.2,
                        include: 'false',
                        position: -1
                    },
                    {
                        educationID: '2',
                        schoolName: 'UofA',
                        gpa: 2.0,
                        include: 'false',
                        position: -1
                    }
                ],
                employment: [
                    {
                        employmentID: '12',
                        companyName: 'Pizza Hut',
                        jobTitle: 'Assistant Manager',
                        beginDate: '2008-01-02',
                        include: 'false',
                        position: -1
                    },
                    {
                        employmentID: '13',
                        companyName: 'Boeing',
                        jobTitle: 'Engineer',
                        beginDate: '2009-03-05',
                        include: 'false',
                        position: -1
                    }
*/
?>