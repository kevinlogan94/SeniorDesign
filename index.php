<!--
Prolog: index.php

Purpose: Landing page for the website. Allows a user to submit a search, register, login, or go to the dashboard if their logged in. 
Preconditions: Input a valid zip code, distance, and checkbox associated for what you are looking for.
Postconditions: Transition to the Search Results page.
-->

<!DOCTYPE html>
<html>
<head>
  <title>Landing Page</title>
  <!--MOBILE-->
  <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.php"); });
   /*
        CheckNumber function
        Purpose: Allow users to only input numbers into the zip code input.
        Parameters: event - What you input into an input. Ex: hitting the "L" key.
        Return:True if you enter backspace or a number, otherwise false.
    */
    function CheckNumber(event){
    var charCode = (event.which) ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
    return true;
    }

  /*
        validateForm function
        Purpose: Allow a user to submit their information or not based on whether the information is filled 
                        out correctly. If not they will be notified on the screen what needs to be filled out.
        Parameters: None
        Return:True if the submit can pass otherwise false.
  */
  function validateForm() {
    var zipval = document.forms["myform"]["ZipCode"].value;
    var ctr = 0;

    if (zipval == null || zipval == "" || zipval.length != 5) {
        document.getElementById("ZipCode").innerHTML = "Please enter a valid 5 digit ZIP code.";
        document.getElementById("ZipCode").style.color = "red"
	ctr++;
    }
    else
    {
	document.getElementById("ZipCode").innerHTML = "";
    }

      //if a checkbox is filled out write error message otherwise leave it blank.
    if ($("input[type='checkbox']").is(":checked"))
    {
       document.getElementById("check").innerHTML = "";
    }
    else
    {
      ctr++;
      document.getElementById("check").innerHTML = " You must click a checkbox.";
      document.getElementById("check").style.color = "red"
    }

    //return false if submit doesn't pass.
    if(ctr > 0)
    {
	return false;
    }
	

  }

   </script>
</head>
<body>

<div class="landing">
<div id="header"></div>
<!--Set up form for search results-->
<form name="myform" action="results.php" method="get" onsubmit="return validateForm()">
    <div class="vert"><div>
    Zip Code<br>
    <input type="text" name="ZipCode" size="5" onkeypress="return CheckNumber(event)"><br>
    <p id="ZipCode"></p></div>
<div>
    Distance<br>
    <select id="soflow" name="formDistance">
      <option value="1">1 mile</option>
      <option value="5">5 miles</option>
      <option value="10">10 miles</option>
      <option value="20">20 miles</option>
      <option value="50">50 miles</option>
    </select><br>
</div>
</div>
<div id="scrolldown"><p>SCROLL DOWN</p>
<span class="chevron bottom"></span></div>
<!--<img src="scrolldown.png" />-->
</div>

<div class="landing bottom">
    Search Tags:<p style="display:inline" id="check"></p><br>
    <?php include 'listtags.php';?>
    <div class="submitcenter"><input type="submit" value="Submit"></div><br><br>
</form>
</div>
</body>
</html>
