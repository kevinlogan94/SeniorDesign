<?php
include 'databaselogin.php';

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

echo nl2br("username = $username \n password = $password \n email = $email\n");

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
$data = mysql_query("SELECT * FROM Logins");
while($row = mysql_fetch_assoc($data))
{
   print_r($row);
   echo nl2br("\n");
}
if ($db_found) {
$result = mysql_query("SELECT * FROM Logins WHERE (username = '$username') OR (email = '$email')");

if ($result && mysql_num_rows($result) > 0)

    {
        echo nl2br("An account is already linked to that username or email"); 
    }
else
    {
	$result = mysql_query("INSERT INTO Logins (username, password, email) 
						VALUES ('$username', '$password', '$email')");
    	echo nl2br("Registration complete\n");
	$data = mysql_query("SELECT * FROM Logins");
	while($row = mysql_fetch_assoc($data))
	{
   	    print_r($row);
   	    echo nl2br("\n");
	}
    }
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
