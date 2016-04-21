<?php
include 'databaselogin.php';

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];

$fullname = $firstname." ".$lastname;

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {
    $result = mysql_query("SELECT * FROM Logins WHERE (username = '$username') OR (email = '$email')");

    if ($result && mysql_num_rows($result) > 0)
    {
      	session_start();
    	$_SESSION['register_error_msg'] = "An account is already linked to that username or email address";
	header('location:register.php');
    }
    else
    {
	$result = mysql_query("INSERT INTO Logins (username, password, email, contact_name, contact_number) 
					VALUES ('$username', '$password', '$email', '$fullname', '$phone')");

        session_start();
        $_SESSION['alert'] = "Your account has been registered";

	header('location:login.php');
    }
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
