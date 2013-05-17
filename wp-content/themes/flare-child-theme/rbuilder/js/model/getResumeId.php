<?php
    header('Access-Control-Allow-Origin: *');
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= 'wp-includes/pluggable.php';
    include($path);

    function getResumeId()
    {

        //$current_dude = wp_get_current_user();

        $current_user = $_GET['currentUser']; //$current_dude->user_login;

        echo $current_user;

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

        $query = sprintf("SELECT currentResume FROM users WHERE email='" . $current_user . "'");

        $result = mysql_query($query);

        $num = mysql_result($result, 0);

        echo $num;

    }
    getResumeId();
?>
