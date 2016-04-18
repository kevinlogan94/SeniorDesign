<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
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

<!--REQUIRED FOR HEADER-->
<div id="header"></div>

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
    //echo nl2br("Charity Registration Complete - id = $new_id\n");
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

<?php
include 'databaselogin.php';

unset($username);
$secret_word = 'the horse raced past the barn fell';
if ($_COOKIE['login']) {
    list($c_username,$cookie_hash) = split(',',$_COOKIE['login']);
    if (md5($c_username.$secret_word) == $cookie_hash) {
        $username = $c_username;
    } else {
        print "You have sent a bad cookie.";
    }
}

if ($username) {
    	echo nl2br("<h1>Welcome, $username.</h1>");
	//print "Welcome, $username. ";
} else {
    header('location:login.php');
}

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
die(mysql_error());
}
//echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
$result = mysql_query("SELECT * FROM Logins WHERE (username = '$username')");

if ($result && mysql_num_rows($result) > 0)

    {
        $user = mysql_fetch_assoc($result);
        //print_r($user);
    }
else
    {
        echo nl2br("User Does Not Exist\n");
    }

$result = mysql_query("SELECT * FROM Charities WHERE (charity_owner = '$username')");

/*if ($result && mysql_num_rows($result) > 0) {
        print_r(mysql_fetch_assoc($result));
        echo "<br>";
}*/
echo nl2br("<div class=\"dashcontainer\">");
while ($row = mysql_fetch_object($result)) {
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
echo nl2br("</div>");
}
else {
print nl2br("Database NOT Found.\n");
mysql_close($db_handle);
}

?>

<!-- List User's name -->
<!-- List charities according to owner -->

<!-- while loop goes here -->
<div style="display:inline;" class="btn" id="editbtn"><a href="#">Edit</a></div>
<div style="display:inline;" class="btn" id="delbtn"><a href="#">Delete</a></div>
<p><a href="newcharity.php">Create new event</a></p>

</body>
</html>
