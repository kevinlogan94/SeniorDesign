<!--
Prolog: access.php

Purpose: Code that handles the login process
Preconditions: Gets input of a username/email and password
Postconditions: If the information is correct, creats login cookie and redirect to dashboard. otherwise return with error.
-->


<?php
include 'databaselogin.php';

$username = $_POST['username'];
$password = $_POST['password'];

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}

$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
// Find any account where the username or email match the password
$result = mysql_query("SELECT * FROM Logins WHERE (username = '$username' OR email = '$username') 
							AND (password = '$password')");

// if there is a match, get array from query result, then use the username 
// and secret word to create a "login" cookie for 3 hours. 
if ($result && mysql_num_rows($result) > 0)

    {
	$user = mysql_fetch_assoc($result); 
	$username = $user['username'];
	$secret_word = 'the horse raced past the barn fell';
        setcookie('login', $username.','.md5($username.$secret_word), time() + 10800); 
        header('location:dashboard.php');
    }
else // return to login page with error message
    {
	session_start();
    	$_SESSION['login_error_msg'] = "Wrong username/email or password";
	header('location:login.php');
    }
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
