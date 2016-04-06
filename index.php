<!DOCTYPE html>
<html>
<head>
  <title>Landing Page</title>

  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });

  //form validation
  function validateForm() {
    var x = document.forms["myform"]["ZIP"].value;
    if (x == null || x == "" || x.length != 5) {
        alert("Zip Code: Please enter a valid 5 digit Zip Code.");
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
  <fieldset align="center">
    <legend>Enter Info</legend>
    Zip Code<br>
    <input type="text" name="ZIP" size="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Distance<br>
    <select name="formDistance">
      <option value="1">1 mile</option>
      <option value="5">5 miles</option>
      <option value="10">10 miles</option>
      <option value="20">20 miles</option>
      <option value="50">50 miles</option>
    </select><br>
</div>
    <?php include 'listtags.php';?>
    <input type="submit" value="Submit"><br><br>
  </fieldset>
</form>
</body>
</html>
