# Nonprofit Organization Search Website
CS499 Senior Design

Group 6: Mandy Cox, Jordan Jorgensen, Kevin Logan

## Installation Guide:

Note: Guide to install on the Multilab servers offered by the University of Kentucky

Set up folder
1.   Log onto your multilab account. 
2.   Type "cd .." to go up a level in the directory
3.   Type "chmod 755 [youruserid]"
4.   cd back to your home folder
5.   Create a directory in your home folder called "HTML"
6.   Type "chmod 755 HTML"

Set up Repository
7. cd into your HTML file.
8. Create a clone from https://github.com/kevinlogan94/SeniorDesign
	Type "git clone https://github.com/kevinlogan94/SeniorDesign.git”
9.   In your HTML folder do "chmod 755 SeniorDesign"
10. Then in the SeniorDesign Folder do "chmod 644 *.php”, "chmod 644 *.css”, "chmod 644 *.png”, and "chmod 644 *.jpg”

Setting up the database

11.    cd into the SeniorDesign directory
12.    Type "mysql -h mysql -p [youruserid] < dump.sql"
13.    It will ask for a password, the default is "u" followed by the last 7 digits of your student id.
14.    Now you have the database.

Getting the code to work for your database

15.    Create a file in the SeniorDesign directory called "databaselogin.php"
16.  In that file, type/copy the following:

<?php
$db_username = "[userid]";
$db_password = "[your mysql password]";
$database = "[userid]";
$server = "mysql";
?>

17.  Remember not to add/push that file to the repository because it is personalized to you.

