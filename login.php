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

  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });
   </script>
</head>
<body>

<!--REQUIRED FOR HEADER-->
<div id="header"></div>
<?php if($logged_in): ?>
<form action="logout.php" method="post">
   <fieldset align="center">
   You are already signed in as <?php echo "$username";?>. Would you like to log out? <br>
   <input type="submit" value="Logout"><br><br>
   </fieldset>
</form>         
<!--Set up form for login information-->
<?php else: ?>
<form action="access.php" method="post">
  <fieldset align="center">
    <legend>Login information</legend>
    Username<br>
    <input type="text" name="username"><br>
    Password<br>
    <input type="text" name="password"><br><br>
    <input type="submit" value="Submit"><br><br>

    <!--Send user to password recovery page if they forgot password-->
    <a href= "passrecover.html">I forgot my password</a>
  </fieldset>
</form>
<?php endif; ?>
</body>
</html>
