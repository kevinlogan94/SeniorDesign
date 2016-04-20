<!--
Prolog: Header.html

Purpose: Allow us to include a header at the top of every page of the website.
Preconditions: Click the helpfinder.us on the top left. Click the For Nonprofits button on the top right, opening a dropdown box.
	Click the login or register button from the dropdown box.
Postconditions: Page transition to the landing page, registration page, or login page depending on what button you press.  
-->

<!DOCTYPE html>
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



<html>
<head>
 <!--set the tab name to Help Finder-->
  <title>Help Finder</title>
  <style>/*CSS*/
ul {/*Set up the main header*/
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #53d563; /*green*/
    font-size:20px;
    width:100%;	
    /*position:fixed;*/
}

li {/*Allow everything on the header to be on the same line*/
    float: left;
}

li a, .dropbtn { /*Set up the text*/
    display: inline-block;
    color: white;
    text-align: left;
    padding: 10px;
    text-decoration: none;
}

li a:hover {
    /*background-color: #306cf2; /*pink*/
}
/*If you're mouse hovers over For Nonprofts it highlights pink*/
.dropbtn:hover, .dropdown:hover {
  background-color: #ff5882; /*pink*/
  border-radius: 10px;
}

li.dropdown { /*Set up the dropdown button for nonprofits*/
    float:right;
    border: solid 1px;
    border-radius: 10px;
    border-color: white;
    margin: 12px;
    font-size: 70%;
}


.dropdown-content { /*Set up the dropdown display*/
    display: none;
    position: absolute;
    background-color: white;
    min-width: 105px;
    box-shadow: #ebebeb;
}

.dropdown-content a { /*Set up the text for the dropdown display*/
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

/*Highlight the dropdown content gray*/
.dropdown-content a:hover {background-color: #ebebeb; /*gray*/}

/*Have the dropdown content be displayed as a block*/
.show {
  display:block;
}
</style>

</head>
<body>
<!--HTML setup-->
<ul>
  <li><a class="active" href="index.php">Help<br>Finder.us</a></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn" onclick="myFunction()">For Nonprofits</a>
    <div class="dropdown-content" id="myDropdown">
<?php 
if ($logged_in) { echo "<a href='logout.php'>Logout</a>"; }
else 		{ echo "<a href='login.php'>Login</a>"; }
?>
      <a href="register.php">Register</a>
      <a href="dashboard.php">Dashboard</a>
    </div>
  </li>
</ul>

<script>
//Javascript
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var d = 0; d < dropdowns.length; d++) {
      var openDropdown = dropdowns[d];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

</body>
</html>


