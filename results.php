<html>
<head>
<!--MOBILE-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });
   </script>
</head>
<body>
<!--Required for header-->
<div id="header"></div>

<?php
include 'databaselogin.php';
utf8_decode();
$ZIP = $_GET['ZipCode'];
$distance = $_GET['formDistance'];

//echo nl2br("ZIP = $ZIP \n distance = $distance miles\n");

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
//echo nl2br("Connected successfully\n");
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
    if(isset($_GET[$row['tag_name']])) {
        if (!$first) {$query .= " OR ";}
        $query .= "(t2c.tag_id = ".$row['tag_id'].")";
        $first = False;
    } 
}
$first = True;
if(isset($_GET['charity_filt'])) {
	$query .= ") AND (c.charity_type=1";
	$first = False;
}
if(isset($_GET['program_filt'])) {
	if($first) {
		$query .= ") AND (c.charity_type=2";
		$first = False;
	} else {
		$query .= " OR c.charity_type=2";
	}	
}
if(isset($_GET['event_filt'])) {
        if($first) {
                $query .= ") AND (c.charity_type=3";
                $first = False;
        } else {
                $query .= " OR c.charity_type=3";
        }
}

$query .= ") AND (c.lat BETWEEN $lat_lower AND $lat_upper) AND (c.lon BETWEEN $lon_lower AND $lon_upper) 
           GROUP BY c.charity_id ORDER BY count(*) DESC";
//echo nl2br("$query\n");
$results = mysql_query($query);
/*while ($row = mysql_fetch_assoc($data))
{
	print_r($row);
	echo nl2br("\n");
}*/
?>
<h1>Your Results</h1>
<nav>
<div style='font-weight:bold;'>Filter by:<br></div>
<form action="results.php" method="get">
<input type='hidden' name="ZipCode" value='<?php echo $ZIP?>'>
<input type='hidden' name="formDistance" value='<?php echo $distance?>'>
<?php
$data = mysql_query("SELECT * FROM Tag");
while($row = mysql_fetch_assoc($data))
{
    if(isset($_GET[$row['tag_name']])) {
        echo nl2br("<input type='hidden' name='".$row['tag_name']."' value='on'>");
    }
}
?>
<input type='checkbox' name="charity_filt" <?php if(isset($_GET['charity_filt'])) {echo "CHECKED";}?>>Charity<br>
<input type='checkbox' name="program_filt" <?php if(isset($_GET['program_filt'])) {echo "CHECKED";}?>>Program<br>
<input type='checkbox' name="event_filt" <?php if(isset($_GET['event_filt'])) {echo "CHECKED";}?>>Event
<input type="submit" value="Filter"><br><br>
</form>
</nav>
<?php
while ($row = mysql_fetch_object($results)) {
	echo nl2br("<div class=\"result\">");
	if ($row->charity_type =="1"){
		echo nl2br("<img src=\"charity.png\"/>");
	} else if ($row->charity_type =="2") {
		echo nl2br("<img src=\"program.png\"/>");
	} else if ($row->charity_type == "3") {
		echo nl2br("<img src=\"event.png\"/>");
	}
	echo nl2br("<div><h2>$row->charity_name</h2>");
	echo nl2br("<p>$row->street_address, $row->city_name, $row->state_abrev $row->zip_code</p>");
	echo nl2br("<p>$row->phone_area-$row->phone_main</p>");
	echo nl2br("<p>$row->charity_description</p>");
	$tags = mysql_query("SELECT t.* FROM Tag t INNER JOIN Tag2Charity t2c ON t.tag_id = t2c.tag_id 
                             WHERE (t2c.charity_id = $row->charity_id)");
        echo nl2br("<p>Tags: ");
	$first = true;
	while ($tag = mysql_fetch_assoc($tags)) {
		if ($first) {
			echo nl2br($tag['tag_string']);
			$first = false;
		} else {
			echo nl2br(", ".$tag['tag_string']);
		} 
	}
	mysql_free_result($tags);
	echo nl2br("</p>");
	echo nl2br("</div></div>"); 
}
mysql_free_result($data);
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
</body>
</html>
