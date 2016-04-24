<!--
Prolog: dashboard.php

Purpose: This is the main hub for the user. It allows them to access all their charities 
as well as all user functions.
Preconditions: The user is logged in with a valid username 
-->


<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
<!--MOBILE-->
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.php"); });
   </script>
</head>
<body>

<!--REQUIRED FOR HEADER-->
<div id="header"></div>

<?php
include 'databaselogin.php';

// check to see if the user is logged in
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

if ($username) { // user is logged on
    echo nl2br("<h1>Welcome, $username.</h1>");
} else { // return to login page
    session_start();
    $_SESSION['alert'] = "You are not logged on";
    header('location:login.php');
}

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}

$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {

    // Find the user in the database that matches the logged in username
    $result = mysql_query("SELECT * FROM Logins WHERE (username = '$username')");
    // if there is a match, get the array from the query
    if ($result && mysql_num_rows($result) > 0)
    {
        $user = mysql_fetch_assoc($result);
    }
    else // otherwise return to login (this shouldn't be able to happen but its here just in case) 
    {
        session_start();
        $_SESSION['alert'] = "You are not logged on";
        header('location:login.php');

    }
    // find all charities that are owned by the user
    $result = mysql_query("SELECT * FROM Charities WHERE (charity_owner = '$username')");

    echo nl2br("<div class=\"dashcontainer\">");
    // for each row in the result, print the information to the screen
    while ($row = mysql_fetch_object($result)) {
        echo nl2br("<div class=\"result\">");
        if ($row->charity_type =="1"){
                echo nl2br("<img src=\"charity.png\"/>");
        } else if ($row->charity_type =="2") {
                echo nl2br("<img src=\"program.png\"/>");
        } else if ($row->charity_type == "3") {
                echo nl2br("<img src=\"event.png\"/>");
        }
        echo nl2br("<div><h2>$row->charity_name</h2>");
        echo nl2br("<p class=\"addressp\">$row->street_address, $row->city_name, $row->state_abrev $row->zip_code</p>");
        echo nl2br("<p class=\"phonep\">$row->phone_area-$row->phone_main</p>");
        echo nl2br("<p class=\"descripp\">$row->charity_description</p>");
        $tags = mysql_query("SELECT t.* FROM Tag t INNER JOIN Tag2Charity t2c ON t.tag_id = t2c.tag_id
                             WHERE (t2c.charity_id = $row->charity_id)");
        echo nl2br("<p class=\"tagsp\">Tags: ");
        $first = true;
        while ($tag = mysql_fetch_assoc($tags)) {
                if ($first) {
                        echo nl2br($tag['tag_string']);
                        $first = false;
                } else {
                        echo nl2br(", ".$tag['tag_string']);
                }
        }
        mysql_free_result($tags);
        echo nl2br("</p>");
        if ($row->start_date != NULL && $row->start_date != "0000-00-00") {
		echo nl2br("<p class=\"classp\">Date: $row->start_date</p>");
	}
	echo nl2br("</div>");
	echo nl2br("<div class=\"btn\"><a href=\"editcharity.php?id=$row->charity_id\">Edit</a></div>");
	echo nl2br("<div class=\"btn\"><a href=\"deletecharity.php?id=$row->charity_id\">Delete</a></div>");
	echo nl2br("</div>");
    }
    echo nl2br("</div>");
}
else {
    print nl2br("Database NOT Found.\n");
    mysql_close($db_handle);
}

?>
<p><a href="changepassword.php">Change Password</a></p> 
<p><a href="newcharity.php">Create new event</a></p>

</body>
</html>
