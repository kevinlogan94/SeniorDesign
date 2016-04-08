<?php

include 'databaselogin.php';

$email = $_POST['email'];
$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
    $result = mysql_query("SELECT * FROM Logins WHERE (email = '$email')");
    if ($result && mysql_num_rows($result) > 0) {
        $user = mysql_fetch_assoc($result);
	$email_from = 'donotreply@helpfinder.com';
	$email_subject = "Password Recovery Request";
	$email_body = "A password request was recently made for the account associated with this email address. The account information is listed below.\n".
            "\n".
            "Email: $email \n".
            "Username: ".$user['username']."\n".
            "Password: ".$user['password']."\n".
            "\n".
            "Thanks,\n".
            "Your friends at HelpFinder\n";


        $headers = "From: $email_from \r\n";
//Send the email!

        mail($email,$email_subject,$email_body,$headers);
//done. redirect to login page. 
        header('Location: login.php');
    } else {
      	session_start();
    	$_SESSION['recover_error_msg'] = "There is no account linked to that email address";
	header('location:passrecover.php');
    }
} else {
    print nl2br("Database NOT Found.\n");
    mysql_close($db_handle);
}



