<?php
include 'databaselogin.php';

$id = $_GET['id'];

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
die(mysql_error());
}
echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
$result = mysql_query("SELECT * FROM Charities WHERE (charity_id = '$id')");

if ($result && mysql_num_rows($result) > 0)

    {
        print_r(mysql_fetch_assoc($result));
    }
else
    {
        echo nl2br("Charity Does Not Exist\n");
    }
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Individual Event Page</title>
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

<!-- List Event Title -->
<!-- List Event Information -->

</body>
</html>
