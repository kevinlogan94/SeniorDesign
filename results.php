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

if ($db_found) {
$data = mysql_query("SELECT * FROM zips WHERE zip_code = $ZIP");
if($row = mysql_fetch_assoc($data)) {
    $orig_lat = $row['lat'];
    $orig_lon = $row['lon'];
    $lat_upper = $orig_lat + ($distance/69);
    $lat_lower = $orig_lat - ($distance/69);
    $lon_upper = $orig_lon + ($distance/abs(cos(deg2rad($orig_lat))*69));
    $lon_lower = $orig_lon - ($distance/abs(cos(deg2rad($orig_lat))*69));
}

$query = "SELECT c.* FROM Charities c INNER JOIN Tag2Charity t2c ON c.charity_id = t2c.charity_id WHERE (";
$first = True;

$data = mysql_query("SELECT * FROM Tag");
while($row = mysql_fetch_assoc($data))
{
    if(isset($_POST[$row['tag_name']])) {
        if (!$first) {$query .= " OR ";}
        $query .= "(t2c.tag_id = ".$row['tag_id'].")";
        $first = False;
    } 
}
$query .= ") AND (c.lat BETWEEN $lat_lower AND $lat_upper) AND (c.lon BETWEEN $lon_lower AND $lon_upper) 
           GROUP BY c.charity_id ORDER BY count(*) DESC";
echo nl2br("$query\n");
$data = mysql_query($query);
while ($row = mysql_fetch_assoc($data))
{
	print_r($row);
	echo nl2br("\n");
}
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
