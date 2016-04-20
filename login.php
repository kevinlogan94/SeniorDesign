<!--
Prolog: login.php

Purpose: Page that allows a user to log in to their created account or go to password recovery page.
Preconditions: Input a username and password, then submit. Otherwise click I forgot my password.
Postconditions: User is transitioned into their own personal user dashboard. Otherwise transitioned
	to the password recovery page.
-->

<?php
$logged_in = False;
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
    $logged_in = True;
}

?>



<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.php"); });


   /*Form Validation Function
     Purpose: Checks to make sure the user has inputted a username and password in order to submit. 
     Preconditions:Click the submit button.
     Postconditions: If a username and/or password aren't inputted, an alert will be posted to the screen and the cancel the submit.
     Return: False if the username/password aren't inputted isn't isn't inputted otherwise true.
   */
   function validateForm() {
    var x = document.forms["myform"]["username"].value;
    var y = document.forms["myform"]["password"].value;
    if (x == null || x == "" || y == null || y == "") {
        alert("Please enter a Username and Password.");
        return false;
    }
   }
   </script>
</head>
<body>

<!--REQUIRED FOR HEADER-->
<div id="header"></div>

<!--Log out setup-->
<?php if($logged_in): ?>
<form action="logout.php" method="post">
   <fieldset align="center">
   You are already signed in as <?php echo "$username";?>. Would you like to log out? <br>
   <input type="submit" value="Logout"><br><br>
   </fieldset>
</form>         
<!--Set up form for login information-->
<?php else: ?>
<div class="box">
 <h1>Login</h1>
<?php 
    session_start();
    if (!empty($_SESSION['login_error_msg'])) {
        echo "<div style=\"color: red; text-align: center;\">Error: ".$_SESSION['login_error_msg']."</div>";
        unset($_SESSION['login_error_msg']);
    }
?>
 <form name = "myform" action="access.php" method="post" onsubmit="return validateForm()">
  <fieldset align="center">
  <hr>
  <label id="icon" for="name"><i class="icon-user"></i></label>
  <input type="text" name="username" placeholder="Username"><br>
  <label id="icon" for="name"><i class="icon-key"></i></label>
  <input type="password" name="password" placeholder="Password"><br><br>
  <input type="submit" value="Submit"><br>
    <!--Send user to password recovery page if they forgot password-->
    <a href= "passrecover.php">I forgot my password</a>
  </fieldset>
 </form>
</div>
<?php endif; ?>
</body>
</html>
