 <?php
 include 'databaselogin.php';
$id = $_GET['id'];
 $db_handle = mysql_connect($server, $db_username, $db_password);
 if (!$db_handle) {
    die(mysql_error());
 }
 $db_found = mysql_select_db($database, $db_handle);
 
$charity = mysql_query("SELECT * FROM Charities WHERE (charity_id = '$id')");

if ($charity && mysql_num_rows($charity) > 0)
    {
	$charity = mysql_fetch_assoc($charity);
        print_r($charity);
    }
else
    {
        header('location:dashboard.php');
    }
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

if ($username != $charity['charity_owner']) {
    header('location:login.php');
} else {
    mysql_query("DELETE FROM Charities WHERE charity_id='$id'");
    mysql_query("DELETE FROM Tag2Charity WHERE charity_id='$id'");
    header('location:dashboard.php');
}
 ?>

