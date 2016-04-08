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

if ($username) {
    print "Welcome, $username. ";
} else {
    header('location:login.php');
}

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
die(mysql_error());
}
echo nl2br("Connected successfully\n");
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
}

$result = mysql_query("SELECT * FROM Charities WHERE (charity_owner = '$username')");

if ($result && mysql_num_rows($result) > 0) {
        print_r(mysql_fetch_assoc($result));
        echo "<br>";
}

else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });
   </script>
</head>
<body>

<!--REQUIRED FOR HEADER-->
<div id="header"></div>

<!-- List User's name -->
<!-- List charities according to owner -->

<!-- while loop goes here -->
<div style="display:inline;" class="btn" id="editbtn"><a href="#">Edit</a></div>
<div style="display:inline;" class="btn" id="delbtn"><a href="#">Delete</a></div>
<p><a href="newcharity.php">Create new event</a></p>

</body>
</html>
