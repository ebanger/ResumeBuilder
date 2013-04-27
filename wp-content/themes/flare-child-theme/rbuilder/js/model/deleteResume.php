<?php
    header('Access-Control-Allow-Origin: *');
	function getData()
	{
        $resumeID = $_POST['resumeID']; 
        
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


        //Execute Resume Deletion
		$query = sprintf("DELETE FROM resume WHERE resumeID='" . $resumeID . "'");
		$result = mysql_query($query); 
        if(!$result)
        {
            die('Could not query: ' . mysql_error());
        }
        else
        {
            echo "Row successfully Deleted!";
        }

		mysql_close($link); 
	}

    getData();

?>
