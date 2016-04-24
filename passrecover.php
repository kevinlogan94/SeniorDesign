<!--
Prolog: passrecover.html

Purpose: Page that allows a user to input their email and have their password sent to them.
Preconditions: Input a valid email address and click submit
Postconditions: User should receive an email including their password.  
-->

<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" type="text/css" href="style.css">
   <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
   <title>Recover Password</title>
   <!--MOBILE-->
  <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">  -->
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.php"); });
  
   /*Form Validation Function
     Purpose: Checks to make sure the user has inputted a valid email address in order to submit. 
     Preconditions:Click the submit button.
     Postconditions: If invalid email in included, an alert will be posted to the screen and the cancel the submit.
     Return: False if the email isn't valid otherwise true.
   */
   function validateForm() {
     var emailval = document.forms["myform"]["email"].value;
     var atpos = emailval.indexOf("@");
     var dotpos = emailval.lastIndexOf(".");
     if (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailval.length) {
	document.getElementById("formerror").innerHTML = "Please enter a valid email address.";  
        document.getElementById("formerror").style.color = "red";        
        return false;
     } 
     else {
	document.getElementById("formerror").innerHTML = "";  
     }
   }
   
   </script>
</head>
<body>

<!--REQUIRED FOR HEADER-->
<div id="header"></div>

<div class="passrecoverbox">
<h1>Recover Password</h1>
<?php
    // checks to see if there is an error message to handle and, if so, displays the message 
    session_start();
    if (!empty($_SESSION['recover_error_msg'])) {
        echo "<div style=\"color: red; text-align: center;\">Error: ".$_SESSION['recover_error_msg']."</div>";
        unset($_SESSION['recover_error_msg']);
    }
?>
<!--Set up form form to receive email for password recovery-->
<form name="myform" action="processrecovery.php" method="post" onsubmit="return validateForm()">
  <fieldset id="shift">
   <p id="formerror"></p>
   <hr>
   <label id="icon" for="name"><i class="icon-user"></i></label>
   <input type="text" name="email" placeholder="Email Address"><br><br>
   <input type="submit" value="Submit">
  </fieldset>
</form>
</div>
</body>
</html>


