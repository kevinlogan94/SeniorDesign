<head>
 <title>Register Charity/Event/Program</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">  
 <!--REQUIRED FOR HEADER-->
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script>$(function(){
 $("#header").load("header.html"); });
 </script>

 <?php
 include 'databaselogin.php';
$id = $_GET['id'];
 $db_handle = mysql_connect($server, $db_username, $db_password);
 if (!$db_handle) {
    die(mysql_error());
 }
 echo nl2br("Connected successfully\n");
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

$user = mysql_fetch_assoc(mysql_query("SELECT * FROM Logins WHERE username = '$username'"));

if ($user['userid'] != $charity['charity_owner']) {
   header('location:login.php');
}


 $data = mysql_query("SELECT * FROM Tag");
 ?>

</head>
<body>
 <!--REQUIRED FOR HEADER-->
 <div id="header"></div>

<form action="stub.php" method="post">
  <fieldset>
    <legend>Edit Your Charity:</legend>
    Event Type:<br>
<?php 
if($charity['charity_type'] == 1) { $charity_selected = 'selected';}
if($charity['charity_type'] == 2) { $program_selected = 'selected';}
if($charity['charity_type'] == 3) { $event_selected = 'selected';}
?>
    <select name="type">
	<option value="1" <?php echo $charity_selected ?>>Charity</option>
	<option value="2" <?php echo $program_selected ?>>Program</option>
	<option value="3" <?php echo $event_selected   ?>>Event</option>
    </select><br>
    Name:<br>
    <input type="text" name="name" value="<?php echo $charity['charity_name'];?>" size="50"><br>
    Address:<br>
    <input type="text" name="address" value="<?php echo $charity['street_address'];?>" size="50"><br>
    City:<br>
    <input type="text" name="city" value="<?php echo $charity['city_name'];?>" size="20"><br>
    State:<br>
    <input type="text" name="state" value="<?php echo $charity['state_abrev'];?>" size="2"><br>
    Zip:<br>
    <input type="number" name="zip" value="<?php echo $charity['zip_code'];?>" size="5"><br>
    Contact Phone Number:<br>
    <input type="text" name="phone_country" value="<?php echo $charity['phone_country'];?>" size="5"> - 
    (<input type="text" name="phone_area" value="<?php echo $charity['phone_area'];?>" size="3" >)
    <input type="text" name="phone_main" value="<?php echo $charity['phone_main'];?>" size="7"><br>
    Description:<br>
    <textarea name="description" cols="100" rows="5" maxlength="500"><?php echo $charity['charity_description'];?>
    </textarea><br><br>
<?php while($row = mysql_fetch_object($data))
      {
          $t2c = mysql_query("SELECT * FROM Tag2Charity WHERE (charity_id = $id) AND (tag_id = $row->tag_id)");
          if ($t2c && mysql_num_rows($t2c) > 0)
          {
	      $checked = 'checked';
          }
          else
          {
              $checked = '';
          }
     
          echo nl2br("<input type='checkbox' name='$row->tag_name' $checked /> $row->tag_string");
          echo nl2br("\n");
      }
?>
   


    <br>
    <input type="submit" value="Submit">
  </fieldset>
</form>
</body>
