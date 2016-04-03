<head>

 <title>Register Charity/Event/Program</title>
  
 <!--REQUIRED FOR HEADER-->
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script>

 $(function(){
   $("#header").load("header.html"); });
  
    //form validation
    function validateForm() {
    var fieldnames = ["Name", "Address", "City", "Description", "Zip Code", "Phone Area Code", "Phone Number"];
    //var alerts = [];
    var str = "";
    //var sizealert = [];    

    //create an array of all empty fields
     for(i = 0; i < fieldnames.length; i++){
	var x = document.forms["myform"][fieldnames[i]].value;

	if(x == null || x == "") {
            str += fieldnames[i]+": Input Required\n";
	}
        else if(fieldnames[i] == "Zip Code" && x.length != 5)
        {
            str += "Zip Code: Enter a valid 5 digit Zip Code.\n";
        }
        else if(fieldnames[i] == "Phone Area Code" && x.length != 3)
        {
            str += fieldnames[i]+": Enter a valid 3 digit Area Code\n";
        }
        else if(fieldnames[i] == "Phone Number" && x.length != 7)
        {
            str += fieldnames[i]+": Please enter a valid phone number\n";
        }
     }
     //Post an alert of all invalid entries    
     if(str != "") {
      alert(str);
      return false;
     }
    
  }
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

<form action="processcharity.php" method="post" name="myform" onsubmit="return validateForm()">
  <fieldset>
    <legend>Register Your Charity:</legend>
    Event Type:<br>
    <select name="type">
	<option value="1">Charity</option>
	<option value="2">Program</option>
	<option value="3">Event</option>
    </select><br>
    Name:<br>
    <input type="text" name="Name" size="50"><br>
    Address:<br>
    <input type="text" name="Address" size="50"><br>
    City:<br>
    <input type="text" name="City" size="20"><br>
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
    <input type="text" name="Zip Code" size="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Contact Phone Number:<br> 
    (<input type="text" name="Phone Area Code" size="3" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>)
    <input type="text" name="Phone Number" size="7" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Description:<br>
    <textarea name="Description" cols="100" rows="5" maxlength="500"></textarea><br><br>

    <?php include 'checks.php';?>


    <br>
    <input type="submit" value="Submit">
  </fieldset>
</form>
</body>
