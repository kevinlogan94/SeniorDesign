<!--
Prolog:changepassword.php

Purpose: Allow the user to change their password to a new value.
Postconditions: Page transition back to their new dashboard. Password updated in the database.
-->


<!DOCTYPE html>
<?php 

// Check to see if the user has a login cookie using the secret word to make sure it isnt fake
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
else { //user isnt logged in so return to login page
     session_start();
    $_SESSION['alert'] = "You are not logged on";
    header('location:login.php');
}
?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <title>Change Password</title>
  <!--MOBILE-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.php"); });

   /*
        validateForm function
        Purpose: Allow a user to submit their information or not based on whether the information is filled 
                        out correctly. If not they will be notified on the screen what needs to be filled out.
        Parameters: None
        Return:True if the submit can pass otherwise false.
  */
   function validateForm() {
    
     var inputs = ["old_password", "new_password"];
     for (i = 0; i < inputs.length; i++) {

	var value = document.forms["myform"][inputs[i]].value;
	if (value == "" || value == null) {
		document.getElementById("formerror").innerHTML = "Provide a current and new password.";
		document.getElementById("formerror").style.color = "red";
		return false;
	}
	else if (inputs[i] == "new_password"){
		var confpassval = document.forms["myform"]["confpass"].value;
		if(value != confpassval) {
			document.getElementById("formerror").innerHTML = "New password doesn't match";	
			document.getElementById("formerror").style.color = "red";
			return false;
		}
        }
	else {
		document.getElementById("formerror").innerHTML = "";
	}   
      }
    }
   </script>
</head>
<body>
 <!--REQUIRED FOR HEADER-->
 <div id="header"></div>
<div class="passchangebox">
 <h1>Change Password</h1>
 <?php 
    // if there is an error message in the session, display the message
    session_start();
    if (!empty($_SESSION['password_error_msg'])) {
        echo "<div style=\"color: red; text-align: center;\">Error: ".$_SESSION['password_error_msg']."</div>";
        unset($_SESSION['password_error_msg']);
    }
 ?>
 <form name="myform" action="updatepassword.php" method="post" onsubmit="return validateForm()">
  <fieldset align="center">
  <p id="formerror"></p>
  <hr>
    <label id="icon"><i class="icon-key"></i></label>  
    <input type="password" name="old_password" placeholder="Current Password"><br>
    <label id="icon"><i class="icon-key"></i></label>  
    <input type="password" name="new_password" placeholder="New Password"><br>
    <label id="icon"><i class="icon-shield"></i></label>
    <input type="password" name="confpass" placeholder="Retype Password"><br><br>
    <input id="shift" type="submit" value="Submit">
 </form>
 </div>
</body>
</html>
