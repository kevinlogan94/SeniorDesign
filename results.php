<!--
Prolog: results.php
Purpose: Page that displays results of the seach form on index.php
Preconditions: Input a zip code, maximum distance, and list of tags
Postconditions: Displays a list of charities withing the range of the zip code that match one or more tags.
Results are sorted by number of matched tags.
-->

<html>
<head>
<!--MOBILE-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.php"); });
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


$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}

$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
    // finds the zip code data for the specified zip code
    $data = mysql_query("SELECT * FROM zips WHERE zip_code = $ZIP");
    if($row = mysql_fetch_assoc($data)) { // if there is a match
        $orig_lat = $row['lat'];
        $orig_lon = $row['lon'];
        // 1 degree of latitude is ~= 69 miles so the range of latitudes is +- distance/69
        $lat_upper = $orig_lat + ($distance/69);
        $lat_lower = $orig_lat - ($distance/69);
        // 1 degree of longitude is ~= cos(latitude)*69, so range of longitude is +- distance/(|cos(lat)*69|) 
        $lon_upper = $orig_lon + ($distance/abs(cos(deg2rad($orig_lat))*69));
        $lon_lower = $orig_lon - ($distance/abs(cos(deg2rad($orig_lat))*69));
}

//start of building query. Finds a charity and joins it with links associated with charity
$query = "SELECT c.* FROM Charities c INNER JOIN Tag2Charity t2c ON c.charity_id = t2c.charity_id WHERE (";
$first = True;

// gets list of tags
$data = mysql_query("SELECT * FROM Tag");
while($row = mysql_fetch_assoc($data)) // for each tag
{
    if(isset($_GET[$row['tag_name']])) { // if tag was checked
        if (!$first) {$query .= " OR ";}
        // add to query that there must be a link between charity and the tag
        $query .= "(t2c.tag_id = ".$row['tag_id'].")"; 
        $first = False;
    } 
}
$first = True;

// if there is a filter by a type of charity, add a requirement that results must be one of the filtered types
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

// finally add that lat and lon must be within the calculated range. Charities that match more than
// one tag are listed multiple times, so group the duplicates and sort by number of times it appeared
// in the list
$query .= ") AND (c.lat BETWEEN $lat_lower AND $lat_upper) AND (c.lon BETWEEN $lon_lower AND $lon_upper) 
           GROUP BY c.charity_id ORDER BY count(*) DESC";

// get the results by making the query
$results = mysql_query($query);
?>
<h1>Your Results</h1>
<div class="resultsdiv">
<nav>
<div style='font-weight:bold;'>Filter by:<br></div>

<!-- Form for filtering. All current form data is resubmitted as hidden inputs -->
<form action="results.php" method="get">
<input type='hidden' name="ZipCode" value='<?php echo $ZIP?>'>
<input type='hidden' name="formDistance" value='<?php echo $distance?>'>
<?php
// gets all tags
$data = mysql_query("SELECT * FROM Tag");
while($row = mysql_fetch_assoc($data)) // for each tag
{
    if(isset($_GET[$row['tag_name']])) { // if tags was selected
        // creates hidden input for tag
        echo nl2br("<input type='hidden' name='".$row['tag_name']."' value='on'>");
    }
}
?>
<input type='checkbox' name="charity_filt" <?php if(isset($_GET['charity_filt'])) {echo "CHECKED";}?>>Charity<br>
<input type='checkbox' name="program_filt" <?php if(isset($_GET['program_filt'])) {echo "CHECKED";}?>>Program<br>
<input type='checkbox' name="event_filt" <?php if(isset($_GET['event_filt'])) {echo "CHECKED";}?>>Event
<br>
<input type="submit" value="Filter"><br><br>
</form>
</nav>
<?php
// prints results 
echo nl2br("<div class=\"afternav\">");
while ($row = mysql_fetch_object($results)) { // for each result, display the information
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
        // gets all tags linked to the charity
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
	if ($row->start_date != NULL || $row->start_date != "0000-00-00") {
		echo nl2br("<p>Date: $row->start_date</p>");
	}
	echo nl2br("</div></div>"); 
}
echo nl2br("</div></div>");
mysql_free_result($data);
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>
</body>
</html>
