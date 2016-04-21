<!--
Prolog: processreg.php
Purpose: Code that handles sumission of the of the registation page
Preconditions: Registation form was submitted successfully
Postconditions: If the username and email are not taken, the account is added to the database. 
Otherwise returns with an error message.
-->

<?php
include 'databaselogin.php';

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];

// puts first name and last name together into a single variable
$fullname = $firstname." ".$lastname;

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {
    // find a user with that username or email address
    $result = mysql_query("SELECT * FROM Logins WHERE (username = '$username') OR (email = '$email')");

    if ($result && mysql_num_rows($result) > 0) // there was a user with the username or email
    {
        // return to form with error message
      	session_start();
    	$_SESSION['register_error_msg'] = "An account is already linked to that username or email address";
	header('location:register.php');
    }
    else // the account is not take
    {
        // insert the account information as a new row in the Logins table of the database
	$result = mysql_query("INSERT INTO Logins (username, password, email, contact_name, contact_number) 
					VALUES ('$username', '$password', '$email', '$fullname', '$phone')");
        
        // redirect to login page with confirmation message
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
