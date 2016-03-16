<?php
include 'databaselogin.php';

$ZIP = $_POST['ZIP'];
$distance = $_POST['formDistance'];

echo nl2br("ZIP = $ZIP \n distance = $distance miles\n");

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);


$data = mysql_query("SELECT tag_string FROM Tag");
while($row = mysql_fetch_assoc($data))
{
   print_r($row);
   echo nl2br("\n");
}
if ($db_found) {

}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
