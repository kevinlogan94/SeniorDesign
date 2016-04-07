<!DOCTYPE html>
<html>
<head>
  <title>Landing Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });

  //form validation
  function validateForm() {
    var zipval = document.forms["myform"]["Zip Code"].value;
    var ctr = 0;

    if (zipval == null || zipval == "" || zipval.length != 5) {
        document.getElementById("Zip Code").innerHTML = "Please enter a valid 5 digit Zip Code.";
        document.getElementById("Zip Code").style.color = "red"
	ctr++;
    }
    else
    {
	document.getElementById("Zip Code").innerHTML = "";
    }

      //if it's checked
    if ($("input[type='checkbox']").is(":checked"))
    {
       document.getElementById("check").innerHTML = "";
    }
    else
    {
      ctr++;
      document.getElementById("check").innerHTML = "You must click a checkbox.";
      document.getElementById("check").style.color = "red"
    }

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
<form name="myform" action="results.php" method="post" onsubmit="return validateForm()">
    <div class="vert"><div>
    Zip Code<br>
    <input type="text" name="Zip Code" size="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    <p id="Zip Code"></p></div>
<div>
    Distance<br>
    <select name="formDistance">
      <option value="1">1 mile</option>
      <option value="5">5 miles</option>
      <option value="10">10 miles</option>
      <option value="20">20 miles</option>
      <option value="50">50 miles</option>
    </select><br>
</div>
</div>
</div>
<div class="landing bottom">
    <p id="check"></p>
    <?php include 'listtags.php';?>
    <input type="submit" value="Submit"><br><br>
</form>
</div>
</body>
</html>
