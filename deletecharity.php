<!--
Prolog: deletecharity.php

Purpose: Deletes the charity specified by the id 
Preconditions: Input an id of a valid charity, and user is logged in as the owner of that charity
Postconditions: If the preconditions are met, the charity is deleted from the database as well as 
all links between the charity and tags.
-->


<?php
include 'databaselogin.php';

$id = $_GET['id'];

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);
if($db_found ) { 
   // find the charity which has the specified id
    $charity = mysql_query("SELECT * FROM Charities WHERE (charity_id = '$id')");
   
    // if there is a match, extract the array
    if ($charity && mysql_num_rows($charity) > 0)
    {
	$charity = mysql_fetch_assoc($charity);
    }
    else // otherwise the charity doesn't exist
    {
        session_start();
        $_SESSION['alert'] = "The charity does not exist";
        header('location:dashboard.php');
    }
    
    // check if the user is logged in as the owner of the charity
    unset($username);
    $secret_word = 'the horse raced past the barn fell';
    if ($_COOKIE['login']) {
        list($c_username,$cookie_hash) = split(',',$_COOKIE['login']);
        if (md5($c_username.$secret_word) == $cookie_hash) {
            $username = $c_username;
        } else {
            print "You have sent a bad cookie.";
        }
    }

    if ($username != $charity['charity_owner']) {  // the user is not the owner, so return with error
        session_start();
        $_SESSION['alert'] = "You do not have permission to do that";
        header('location:login.php');
    } else {
        // delete the charity 
        mysql_query("DELETE FROM Charities WHERE charity_id='$id'");
        // delete all links between the charity and tags
        mysql_query("DELETE FROM Tag2Charity WHERE charity_id='$id'");
        
        // return to the dashboard with a alert message
        session_start();
        $_SESSION['alert'] = "Your charity has been deleted";
        header('location:dashboard.php');
    }
}
?>

