<?php
include 'databaselogin.php';

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
$data = mysql_query("SELECT * FROM Tag");
?>

<form action="processcharity.php" method="post">
  <fieldset>
    <legend>Register Your Charity:</legend>
    Event Type:<br>
    <select name="type">
	<option value="1">Charity</option>
	<option value="2">Program</option>
	<option value="3">Event</option>
    </select><br>
    Name:<br>
    <input type="text" name="name" size="50"><br>
    Address:<br>
    <input type="text" name="address" size="50"><br>
    City:<br>
    <input type="text" name="city" size="20"><br>
    State:<br>
    <input type="text" name="state" size="2"><br>
    Zip:<br>
    <input type="number" name="zip" size="5"><br>
    Contact Phone Number:<br>
    <input type="text" name="phone_country" size="5"> - 
    (<input type="text" name="phone_area" size="3" >)
    <input type="text" name="phone_main" size="7"><br>
    Description:<br>
    <textarea name="description" cols="100" rows="5" maxlength="500"></textarea><br><br>

<?php
while($row = mysql_fetch_assoc($data))
{
   echo "<input type=\"checkbox\" name=\"".$row['tag_name']."\" 
          value=\"".$row['tag_name']."\">".$row['tag_string']."<br>";
}
?>
    <br>
    <input type="submit" value="Submit">
  </fieldset>
</form>
