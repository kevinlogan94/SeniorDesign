<?php
include 'databaselogin.php';

$username = $_POST['username'];
$password = $_POST['password'];

echo nl2br("username = $username \n password = $password\n");

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
$result = mysql_query("SELECT * FROM Logins WHERE (username = '$username' OR email = '$username') 
							AND (password = '$password')");

if ($result && mysql_num_rows($result) > 0)

    {
	$user = mysql_fetch_assoc($result);
	$username = $user['username'];
	$secret_word = 'the horse raced past the barn fell';
        setcookie('login', $username.','.md5($username.$secret_word), time() + 10800); 
        header('location:dashboard.php');
    }
else
    {
    	echo nl2br("Username and Password NOT Found\n");
    }
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
