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
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });


   //form validation
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
 <form name = "myform" action="access.php" method="post" onsubmit="return validateForm()">
  <fieldset align="center">
  <hr>
  <label id="icon" for="name"><i class="icon-user"></i></label>
  <input type="text" name="username" placeholder="Username"><br>
  <label id="icon" for="name"><i class="icon-shield"></i></label>
  <input type="password" name="password" placeholder="Password">
  <input type="submit" value="Submit"><br>
    <!--Send user to password recovery page if they forgot password-->
    <a href= "passrecover.html">I forgot my password</a>
  </fieldset>
 </form>
</div>
<?php endif; ?>
</body>
</html>
