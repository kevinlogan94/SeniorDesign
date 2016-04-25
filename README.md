# SeniorDesign
CS499 Senior Design

Group 6

Nonprofit Organization Search Website

Files include:

access.php - File handles submission of login form

dashboard.php - File for the Dashboard. Page that allows organizations to edit, delete, and create events/programs/charities.

databaselogin.php - Individual file for each group member to include database login information.

dump.sql - Creates the required tables.

editcharity.php - Form that allows user to edit their charities 

event.php - Page for individual event information.

header.php - File included in each page of the website. Allows each page to have a header at the top.

index.php - Main Landing page file for the site.

landingpage.php - Temporary page to show correct database functionality/connections.

listtags.php - File incorporated into other pages to display tags from the database as checkboxes.

login.php - File for the login page. Allows users to login into their personal account.

logout.php - File used to allow users to logout of their account. Included on login page.

mainbg.jpg - Picture used in the background of the landing page.

newcharity.php - File for the create new event/program/charity page. 

passrecover.php - File for the password recovery page

processcharity.php - File that handles sumission of the new charity form

publicuserpage.php - Public page for users to see all of the events/charities/programs for a single registered nonprofit.

README.md - This File

register.html - File for the Registration page for organizations.

register.php - Page for new user registration.

results.php - Page listing results for user from home page.

style.css - Main css file used for the overall styling of the website.

#Installation Guide:

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

