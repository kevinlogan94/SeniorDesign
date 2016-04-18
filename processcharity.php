<?php
include 'databaselogin.php';

$type = $_POST['type'];
$name = $_POST['Name'];
$address = $_POST['Address'];
$city = $_POST['City'];
$state = $_POST['State'];
$zip = $_POST['ZipCode'];
$phone_area = $_POST['Area'];
$phone_main = $_POST['Phone'];
$description = $_POST['Description'];
$owner = $_POST['owner'];
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];
$date = $year."-".$month."-".$day;
$lat = 0;
$lon = 0;

//echo nl2br("name = $name \n type = $type \n zip = $zip\n");

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
//echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
$data = mysql_query("SELECT * FROM Charities");
//while($row = mysql_fetch_assoc($data))
//{
//   print_r($row);
//   echo nl2br("\n");
//}
if ($db_found) {
   $data = mysql_query("SELECT * FROM zips WHERE zip_code=$zip");
   if($row = mysql_fetch_assoc($data)) {
       $lat = $row['lat'];
       $lon = $row['lon'];
   }
   $result = mysql_query("INSERT INTO Charities 
			   (charity_type, charity_name, street_address, city_name, state_abrev, 
                           zip_code, phone_area, phone_main, charity_description, start_date,
                           charity_owner, lat, lon)
			   VALUES
			   ('$type', '$name', '$address', '$city', '$state', '$zip', '$phone_area', 
                            '$phone_main', '$description', '$date', '$owner', '$lat', '$lon')");
    $new_id = mysql_insert_id($db_handle);
    echo nl2br("Charity Registration Complete - id = $new_id\n");
    /*$data = mysql_query("SELECT * FROM Charities");
    while($row = mysql_fetch_assoc($data))
    {
	print_r($row);
	echo nl2br("\n");
    }
    $data = mysql_query("SELECT * FROM Tag");
    while($row = mysql_fetch_assoc($data))
    {
	if(isset($_POST[$row['tag_name']])) {
	    echo nl2br("Tagging with ".$row['tag_name']."\n");
            $result = mysql_query("INSERT INTO Tag2Charity 
				  (tag_id, charity_id) VALUES ('".$row['tag_id']."', '$new_id')");
	}
    }
    $data = mysql_query("SELECT * FROM Tag2Charity");
    while($row = mysql_fetch_assoc($data))
    {
	print_r($row);
	echo nl2br("\n");
    }  */  
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?> 
