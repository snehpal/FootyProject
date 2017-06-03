<?php
include_once('/var/www/html/final_project/finalproject-lib.php');
include_once('/var/www/html/final_project/header.php');
echo "
<html>
<head>
<title> Login Page </title>
<body>
<center>
	<form method=post action=add.php>
	<table>
	Username: <input type=\"text\" name=\"postuser\">
	<tr><td>Password:&nbsp <input type=\"password\" name=\"postpass\"></td></tr>
	<tr><td><input type=\"submit\" name=\"submit\" value=\"Login\">
	</td></tr></table>
	</form>
	<a href=register.php> Click Here for First Time Users </a>
</body>
</html>
"; 
?>

