<?php
include 'databaselogin.php';

$id = $_GET['id'];

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
die(mysql_error());
}
echo nl2br("Connected successfully\n");
$db_found = mysql_select_db($database, $db_handle);
if ($db_found) {
$user = mysql_query("SELECT * FROM Logins WHERE (userid = '$id')");
$charities = NULL;
if ($user && mysql_num_rows($user) > 0)
    {
        print_r(mysql_fetch_assoc($user));
        echo "<br>";
        $charities = mysql_query("SELECT * FROM Charities WHERE charity_owner = '$id'");
        if ($charities && mysql_num_rows($charities) > 0)
        {
            while($row = mysql_fetch_assoc($charities))
            {
   		print_r($row);
   		echo nl2br("\n");
	    }
        }
        else
        {
            echo nl2br("No Charities to Display\n");
        }       
    }
else
    {
        echo nl2br("User Does Not Exist\n");
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
    echo nl2br("<div class=\"afternav\">");
    // for each row in the result, print the information to the screen
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
        echo nl2br("<div class=\"btn\"><a href=\"editcharity.php?id=$row->charity_id\">Edit</a></div>");
        echo nl2br("<div class=\"btn\"><a href=\"deletecharity.php?id=$row->charity_id\">Delete</a></div>");
        echo nl2br("</div>");
    }
    echo nl2br("</div>");
}
else {
    print nl2br("Database NOT Found.\n");
    mysql_close($db_handle);
}

?>



</body>
</html>

