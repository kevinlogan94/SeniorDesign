<?php
include 'databaselogin.php';

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
//echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
$data = mysql_query("SELECT * FROM Tag");
?>
<form action="">
<?php
while($row = mysql_fetch_assoc($data))
{
   //echo "<input type=\"checkbox\" name=\"".$row['tag_name']."\" value=\"".$row['tag_name']."\">".$row['tag_string']."<br>";
   echo "<div class=\"checkdiv\">
	<input class=\"checkbox-custom\" type=\"checkbox\" id=\"in".$row['tag_name']."\" name=\"".$row['tag_name']."\" />
	<label class=\"checkbox-custom-label\" for=\"in".$row['tag_name']."\">".$row['tag_string']."</label>
</div>";
}
?>
