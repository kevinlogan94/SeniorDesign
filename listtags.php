<!--
Prolog: listtags.php
Purpose: Supplementary file that can be included to display the tag check boxes to reduce code reuse.
Preconditions: Nothing
Postconditions: Displays a list of check boxes to be used with a form
-->

<?php
include 'databaselogin.php';

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}

$db_found = mysql_select_db($database, $db_handle);
// get the list of tags
$data = mysql_query("SELECT * FROM Tag");
?>
<form action="">
<?php
// iterate over each tag in the list and print the appropriate html 
while($row = mysql_fetch_assoc($data))
{
   echo "<div class=\"checkdiv\">
	 <input class=\"checkbox-custom\" type=\"checkbox\" 
         id=\"in".$row['tag_name']."\" name=\"".$row['tag_name']."\" />
	 <label class=\"checkbox-custom-label\" 
         for=\"in".$row['tag_name']."\">".$row['tag_string']."</label>
         </div>";
}
?>
