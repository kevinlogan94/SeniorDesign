<!--
Prolog: updatecharity.php
Purpose: Code that handles sumission of the editcharity form
Preconditions: Edit charity form is sumbitted successfully, user is logged in as owner of the charity
Postconditions: if user owns charity, charity is updated with new information
-->

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
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];
$id = $_POST['id'];
$date = $year."-".$month."-".$day;
$lat = 0;
$lon = 0;


$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
    die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {
    // gets the charity with the given id
    $charity = mysql_query("SELECT * FROM Charities WHERE (charity_id = '$id')");

    if ($charity && mysql_num_rows($charity) > 0) // of there is a match, extract array
    {
	$charity = mysql_fetch_assoc($charity);
    }
    else // else the charity does not exist
    { 
         session_start();
         $_SESSION['alert'] = "The charity does not exist";
         header('location:dashboard.php');
    }
    
    // makes sure the user is the owner of the charity
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

    if ($username != $charity['charity_owner']) { // user isn't allowed to edit charities they do not own
        session_start();
        $_SESSION['alert'] = "You do not have permission to do that";
        header('location:dashboard.php');
    }

   // get zip code data for given zip code
   $data = mysql_query("SELECT * FROM zips WHERE zip_code=$zip");
   if($row = mysql_fetch_assoc($data)) { // get latitude and longitude from zip code data
       $lat = $row['lat'];
       $lon = $row['lon'];
   }
   
   // updates the charity table entry to match the new data
   $result = mysql_query("UPDATE Charities SET
			   charity_type='$type', charity_name='$name', street_address='$address', 
			   city_name='$city', state_abrev='$state', zip_code='$zip', phone_area='$phone_area', 
                           phone_main='$phone_main', charity_description='$description', start_date='$date',
                           charity_owner='$username', lat='$lat', lon='$lon'
			   WHERE charity_id='$id'");
   
    // delete all the links to tags for this charity
    mysql_query("DELETE FROM Tag2Charity WHERE charity_id='$id'");
    
    //create new links to tags
    $data = mysql_query("SELECT * FROM Tag");
    while($row = mysql_fetch_assoc($data))
    {
	if(isset($_POST[$row['tag_name']])) {
            $result = mysql_query("INSERT INTO Tag2Charity 
				  (tag_id, charity_id) VALUES ('".$row['tag_id']."', '$id')");
	}
    }

    // return with confirmation message
    session_start();
    $_SESSION['alert'] = "Your charity has been updated";
    header('location:dashboard.php'); 
}
else {
    print nl2br("Database NOT Found.\n");
    mysql_close($db_handle);
}

?> 
