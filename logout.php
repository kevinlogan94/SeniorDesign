<?php
if (isset($_COOKIE['login'])) {
	unset($_COOKIE['login']);
	setcookie('login', '', time() - 3600);
}
session_start();
$_SESSION['alert'] = "You have been logged out";

header('location:login.php');
?>
