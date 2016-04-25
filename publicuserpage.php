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
Last login: Sun Apr 24 19:35:06 on ttys001
Mirandas-MacBook-Pro:~ mandycox$ ssh mdco232@pen.cs.uky.edu
mdco232@pen.cs.uky.edu's password: 
-----------------------------
University of Kentucky Computer Science Facility
penstemon.cs.engr.uky.edu Linux 3.13.0-77-generic x86_64 (DMB 005)

This computer is for authorized users only.  Use of this computer
expresses consent to having all activities monitored by CS personnel to
maintain security and is governed by the University policy governing
access to and use of UK computing resources.


2015-08-01 - Matlab 2015b installed on all machines.

	paul, 1 Aug 2015
-----------------------------
Last login: Sun Apr 24 19:33:08 2016 from 10.20.193.228
penstemon:~> cd HTML/SeniorDesign
penstemon:~/HTML/SeniorDesign> ls
access.php	    event.php	     mainbg.jpg		  README.md
changepassword.php  event.png	     newcharity.php	  register.php
charity.png	    header.php	     passrecover.php	  results.php
dashboard.php	    index.php	     processcharity.php   scrolldown.png
databaselogin.php   landingpage.php  processrecovery.php  style.css
deletecharity.php   listtags.php     processreg.php	  updatecharity.php
dump.sql	    login.php	     program.png	  updatepassword.php
editcharity.php     logout.php	     publicuserpage.php
penstemon:~/HTML/SeniorDesign> vim results.php
penstemon:~/HTML/SeniorDesign> vim results.php
penstemon:~/HTML/SeniorDesign> vim publicuserpage.php
penstemon:~/HTML/SeniorDesign> vim results.php
penstemon:~/HTML/SeniorDesign> vim results.php
penstemon:~/HTML/SeniorDesign> vim publicuserpage.php
penstemon:~/HTML/SeniorDesign> vim dashboard.php


















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

