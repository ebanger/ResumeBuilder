<?php
    header('Access-Control-Allow-Origin: *');
    
    function getResumeId()
    {
        $resumeID = $_POST['resumeID'];

        $current_dude = wp_get_current_user();

        $current_user = $current_dude->user_login;
        
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

        $query = sprintf("UPDATE users SET currentResume = '$resumeID' WHERE email= '" . $current_user . "'");

    }
    getResumeId();
?>
