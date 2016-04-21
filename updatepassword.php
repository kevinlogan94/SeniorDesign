<!--
Prolog: updatepassword.php

Purpose: Handles the logic and database manipulation behind the change password page.
Preconditions: Has input of a old and new password from the user
Postconditions: If current password is correct, password is updated to new value. If not,
return to change password page with error message.
-->
<?php

include 'databaselogin.php';
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
if (!$username) {
    session_start();
    $_SESSION['alert'] = "You are not logged in";
    header('location:login.php');
}
$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
die(mysql_error());
}

$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {
    $result = mysql_query("SELECT * FROM Logins WHERE (username = '$username')");
    if ($result && mysql_num_rows($result) > 0)
    {
        $user = mysql_fetch_assoc($result);
        print_r($user);
    }
    else
    {
        echo nl2br("User Does Not Exist\n");
    }

    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];

    if ($old_pass != $user['password']) {
        session_start();
    	$_SESSION['password_error_msg'] = "The current password you entered was not correct";
	header('location:changepassword.php');
    } else {
	$result = mysql_query("UPDATE Logins SET password='$new_pass' WHERE username='$username'");
	session_start();
	$_SESSION['alert'] = "Password was updated successfully";
	header('location:dashboard.php');
    }
}   
?>



