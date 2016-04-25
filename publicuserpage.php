<?php
include 'databaselogin.php';

$id = $_GET['id'];

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
    $user = mysql_query("SELECT * FROM Logins WHERE (userid = '$id')");
    $charities = NULL;
    $no_user = True;
    if ($user && mysql_num_rows($user) > 0)
    {
        $user = mysql_fetch_assoc($user);
        $charities = mysql_query("SELECT * FROM Charities WHERE charity_owner = '".$user['username']."'");
	$no_user = False;
    }
}
else {
    print nl2br("Database NOT Found.\n");
    mysql_close($db_handle);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Individual User Page</title>
  <!--MOBILE-->
  <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
  <!--REQUIRED FOR HEADER-->
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.php"); });
   </script>
</head>
<body>

<!--REQUIRED FOR HEADER-->
<div id="header"></div>

<!-- List Event Title -->
<!-- List Event Information -->

<?php
    echo nl2br("<h1>Charities/Events/Programs by ".$user['username']."</h1>");
    echo nl2br("<div class=\"publicuser\">");
    // for each row in the result, print the information to the screen
    while ($row = mysql_fetch_object($charities)) {
        echo nl2br("<div class=\"result\">");
        if ($row->charity_type =="1"){
                echo nl2br("<img src=\"charity.png\"/>");
        } else if ($row->charity_type =="2") {
                echo nl2br("<img src=\"program.png\"/>");
        } else if ($row->charity_type == "3") {
                echo nl2br("<img src=\"event.png\"/>");
        }
        echo nl2br("<div><h2>$row->charity_name</h2>");
        echo nl2br("<p class=\"addressp\">$row->street_address, $row->city_name, $row->state_abrev $row->zip_code</p>");
        echo nl2br("<p class=\"phonep\">$row->phone_area-$row->phone_main</p>");
        echo nl2br("<p class=\"descripp\">$row->charity_description</p>");
        $tags = mysql_query("SELECT t.* FROM Tag t INNER JOIN Tag2Charity t2c ON t.tag_id = t2c.tag_id
                             WHERE (t2c.charity_id = $row->charity_id)");
        echo nl2br("<p class=\"tagsp\">Tags: ");
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
        if ($row->start_date != NULL && $row->start_date != "0000-00-00") {
                echo nl2br("<p class=\"classp\">Date: $row->start_date</p>");
        }
        echo nl2br("</div>");
        echo nl2br("</div>");
    }
    echo nl2br("</div>");

?>



</body>
</html>

