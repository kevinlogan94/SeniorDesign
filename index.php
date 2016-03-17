<!DOCTYPE html>
<html>
<head>
  <title>Landing Page</title>

  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });
   </script>
</head>
<body>

<!--REQUIRED FOR HEADER-->
<div id="header"></div>

<!--Set up form for search results-->
<form action="landingpage.php" method="post">
  <fieldset align="center">
    <legend>Enter Info</legend>
    ZIP Code<br>
    <input type="text" name="ZIP"><br>
    Distance<br>
    <select name="formDistance">
      <option value="1">1 mile</option>
      <option value="5">5 miles</option>
      <option value="10">10 miles</option>
      <option value="20">20 miles</option>
      <option value="50">50 miles</option>
    </select><br>

    <?php include 'checks.php';?>
    <input type="submit" value="Submit"><br><br>
  </fieldset>
</form>
</body>
</html>
