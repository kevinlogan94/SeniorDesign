<?php
if (isset($_COOKIE['login'])) {
	unset($_COOKIE['login']);
	setcookie('login', '', time() - 3600);
}
header('location:login.php');
?>
