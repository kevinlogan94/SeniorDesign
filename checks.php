<?php
include 'databaselogin.php';

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {
    $data = mysql_query("SELECT * FROM Tag;");
    while($row = mysql_fetch_object($data))
    {
        echo nl2br("<input type='checkbox' name='$row->tag_name'  /> $row->tag_string");
        echo nl2br("\n");
    }
}
else {
    print nl2br("Database NOT Found.\n");
    mysql_close($db_handle);
}

?>
