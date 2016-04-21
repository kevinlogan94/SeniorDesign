<!--
Prolog: newcharity.php

Purpose: Page that allows a user to create a new event/program/charity.	
Preconditions: Input a name, date(if applicable), address, city, zip code, description, state, contact phone number,
	and tags associated with this. 
Postconditions: Users new event/program/charity is put into the database. Page transition to the dashboard page.
-->

<?php
include 'databaselogin.php';
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

if (!$username) {
    session_start();
    $_SESSION['alert'] = "You are not logged on";
    header('location:login.php');
}

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
   die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);
$data = mysql_query("SELECT * FROM Tag");
?>

<head>
 <link rel="stylesheet" type="text/css" href="style.css">
 <title>Register Charity/Event/Program</title>
 <!--MOBILE-->
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" type="text/css" href="style.css">
 <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
 <!--REQUIRED FOR HEADER-->
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script>
//insert header
 $(function(){
   $("#header").load("header.php"); });
    /*
	validateForm function
	Purpose: Allow a user to submit their information or not based on whether the information is filled 
			out correctly. If not they will be notified on the screen what needs to be filled out.
	Parameters: None
	Return:True if the submit can pass otherwise false.
    */
    function validateForm() {
    var inputs = ["Name", "Address", "City", "Description", "ZipCode", "Area", "Phone"];
    var str = "";
    var ctr = 0;

    //Goes through the values of all inputs. Print a input error if it doesn't meet requirements
     for(i = 0; i < inputs.length; i++){
	var value = document.forms["myform"][inputs[i]].value;
 
	if(value == null || value == "") {
	   ctr++;
	   if(inputs[i] == "Area") {
                document.getElementById("Phone").innerHTML = " Input Required.";
		document.getElementById("Phone").style.color = "red";
            }
            else {
		document.getElementById(inputs[i]).innerHTML = " Input Required.";
                document.getElementById(inputs[i]).style.color = "red";
            }
	}
        else if(inputs[i] == "ZipCode" && value.length != 5)
        {
	   ctr++;
           document.getElementById(inputs[i]).innerHTML = "  Enter a valid 5 digit Zip Code.";
           document.getElementById(inputs[i]).style.color = "red";
	}
        else if(inputs[i] == "Area" && value.length != 3)
        {
           ctr++;
           document.getElementById(inputs[i]).innerHTML = "  Enter a valid 3 digit Area Code.";
           document.getElementById(inputs[i]).style.color = "red";
	}
        else if(inputs[i] == "Phone" && value.length != 7)
        {
	    ctr++;
            document.getElementById(inputs[i]).innerHTML = " Enter a valid phone Number.";
           document.getElementById(inputs[i]).style.color = "red" 
        }
	else
	{
	    document.getElementById(inputs[i]).innerHTML = "";
	}
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

     //if there was in input error cancel the submit.
     if(ctr > 0)
     {
	return false;
     }
  }
</script>


</head>
<body>
 <!--REQUIRED FOR HEADER-->
 <div id="header"></div>
<div class="newcharitybox">
<form action="processcharity.php" method="post" name="myform" onsubmit="return validateForm()">
  <fieldset>
    <h1>Register Your Charity/Event/Program</h1>
    <hr>
    Type:<br>
    <select id="dropdowntextarea" name="type">
	<option value="1">Charity</option>
	<option value="2">Program</option>
	<option value="3">Event</option>
    </select><br>
    Name:<p style="display:inline" id="Name"></p><br>
    <input type="text" name="Name" size="50"><br>
    Date(if applicable):<br>
    <select id="dropdowntextarea" name="month" size="1">
        <option value="00">month</option>
	<option value="01">January</option>
    	<option value="02">February</option>
    	<option value="03">March</option>
    	<option value="04">April</option>
    	<option value="05">May</option>
    	<option value="06">June</option>
    	<option value="07">July</option>
   	<option value="08">August</option>
    	<option value="09">September</option>
    	<option value="10">October</option>
    	<option value="11">November</option>
    	<option value="12">December</option>
    </select> / 
    <select id="dropdowntextarea" style="margin-left: 0px;" name="day">
	<option value="00">dd</option>    
	<option value="01">01</option>
    	<option value="02">02</option>
    	<option value="03">03</option>
    	<option value="04">04</option>
    	<option value="05">05</option>
    	<option value="06">06</option>
    	<option value="07">07</option>
    	<option value="08">08</option>
    	<option value="09">09</option>
    	<option value="10">10</option>
    	<option value="11">11</option>
    	<option value="12">12</option>
    	<option value="13">13</option>
    	<option value="14">14</option>
    	<option value="15">15</option>
    	<option value="16">16</option>
    	<option value="17">17</option>
    	<option value="18">18</option>
    	<option value="19">19</option>
    	<option value="20">20</option>
    	<option value="21">21</option>
    	<option value="22">22</option>
    	<option value="23">23</option>
    	<option value="24">24</option>
    	<option value="25">25</option>
    	<option value="26">26</option>
    	<option value="27">27</option>
    	<option value="28">28</option>
    	<option value="29">29</option>
    	<option value="30">30</option>
    	<option value="31">31</option>
    </select> / 
    <select id="dropdowntextarea" style="margin-left: 0px;" name="year">
	<option value="0000">yyyy</option>
        <option value="2016">2016</option>
	<option value="2017">2017</option>
	<option value="2018">2018</option>
	<option value="2019">2019</option>
	<option value="2020">2020</option>
	<option value="2021">2021</option>
	<option value="2022">2022</option>
	<option value="2023">2023</option>
	<option value="2024">2024</option>
	<option value="2025">2025</option>
	<option value="2026">2026</option> 
   </select>
    <br>
    Address:<p style="display:inline" id="Address"></p><br>
    <input type="text" name="Address" size="50"><br>
    City: <p style="display:inline" id="City"></p><br>
    <input type="text" name="City" size="20"><br>
    State:<br>
    <select id="dropdowntextarea" name = "State">
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
    Zip Code: <p style="display:inline" id="ZipCode"></p><br>
    <input type="text" name="ZipCode"  size="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Contact Phone Number: <p style="display:inline" id="Phone"></p><p style="display:inline" id="Area"></p><br> 
    <input type="text" name="Area" placeholder="###" size="2" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
    - <input type="text" id="phoneshift" name="Phone" placeholder="#######"size="7" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Description: <p style="display:inline" id="Description"></p><br>
    <textarea id="dropdowntextarea" name="Description" cols="100" rows="5" maxlength="500"></textarea><br><br>

    Tags Related:<p style="display:inline" id="check"></p><br>
    <?php include 'listtags.php';?>

    <br>
    <input type="submit" value="Submit">
  </fieldset>
</div>
</form>
</body>
