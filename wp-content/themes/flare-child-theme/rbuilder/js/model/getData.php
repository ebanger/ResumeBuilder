<?php
    header('Access-Control-Allow-Origin: *');
    function getData()
    {

        //$current_dude = wp_get_current_user();

        $current_user = $_GET['currentUser'];//$current_dude->user_login;
        
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
        $query = sprintf("SELECT firstname, lastname, userID, address1, address2, city, state, phone1, email from users WHERE email='" . $current_user . "'");
        $result = mysql_query($query); 
        if(!$result)
        {
            die('Could not query: ' . mysql_error());
        }

        
        while($row = mysql_fetch_assoc($result))
        {
            $basics = array ('name'=>$row['firstname'] . " " . $row['lastname'], 'userID'=>$row['userID'],
             'street'=>$row['address1'], 'address2'=>$row['address2'], 'city'=>$row['city'], 'state'=>$row['state'], 'email'=>$row['email'], 'phone1'=>$row['phone1']);  
        }

        $current_ID = $basics['userID'];

        //Acquire Education Information//
        $query = sprintf("SELECT educationID, schoolName, gpa, gradyear, degreeType, degree, honors, city, state from education where userID='" . $current_ID . "'");
        $result = mysql_query($query);
        if(!$result)
        {
            die('Could not query: ' . mysql_error());
        }

        $edu = array();
        while($r = mysql_fetch_assoc($result))
        {
            $edu[] = $r;
        }

        //Acquire Employment Information//
        $query = sprintf("SELECT employmentID, companyName, jobTitle, beginDate, endDate, achievements, city, state, reason from employment where userID='" . $current_ID . "'");
        $result = mysql_query($query);
        if(!$result)
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