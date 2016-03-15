<?php
include 'databaselogin.php';

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
$data = mysql_query("SELECT tag_name FROM Tag");
?>
<form action="">
<?php
while($row = mysql_fetch_assoc($data))
{
   echo "<input type=\"checkbox\" name=\"tag\" value=\"".$row['tag_name']."\">".$row['tag_name']."<br>";
}
?>
