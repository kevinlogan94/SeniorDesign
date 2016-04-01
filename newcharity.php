<head>
 <title>Register Charity/Event/Program</title>
  
 <!--REQUIRED FOR HEADER-->
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script>$(function(){
 $("#header").load("header.html"); });
 </script>

 <?php
 include 'databaselogin.php';

 $db_handle = mysql_connect($server, $db_username, $db_password);
 if (!$db_handle) {
    die(mysql_error());
 }
 echo nl2br("Connected successfully\n");
 $db_found = mysql_select_db($database, $db_handle);
 $data = mysql_query("SELECT * FROM Tag");
 ?>

</head>
<body>
 <!--REQUIRED FOR HEADER-->
 <div id="header"></div>

<form action="processcharity.php" method="post">
  <fieldset>
    <legend>Register Your Charity:</legend>
    Event Type:<br>
    <select name="type">
	<option value="1">Charity</option>
	<option value="2">Program</option>
	<option value="3">Event</option>
    </select><br>
    Name:<br>
    <input type="text" name="name" size="50"><br>
    Address:<br>
    <input type="text" name="address" size="50"><br>
    City:<br>
    <input type="text" name="city" size="20"><br>
    State:<br>
    <select name = "type">
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
    </select><br>
    Zip:<br>
    <input type="text" id = 300 name="zip" size="5"><br>
    <!--Allows only integers to be included in text area-->
    <script>
    $('#300').keypress(function(e) {
    var a = [];
    var k = e.which;

    for (i = 48; i < 58; i++)
        a.push(i);

    if (!(a.indexOf(k)>=0))
        e.preventDefault();
    });
    </script>


    Contact Phone Number:<br>
    <input type="text" name="phone_country" size="5"> - 
    (<input type="text" name="phone_area" size="3" >)
    <input type="text" name="phone_main" size="7"><br>
    Description:<br>
    <textarea name="description" cols="100" rows="5" maxlength="500"></textarea><br><br>

    <?php include 'checks.php';?>


    <br>
    <input type="submit" value="Submit">
  </fieldset>
</form>
</body>
