<?php
include_once('/var/www/html/final_project/header.php');
if ($_POST["personname"]) {
	$recipient="snehpal.sngh@gmail.com";
   	$subject="User Registration";
    	$sender=$_POST["personname"];
    	$username=$_POST["username"];
    	$passw=$_POST["password"];
    	$senderEmail=$_POST["senderEmail"];

    	$mailBody="Name: $sender \nUsername: $username \nPassword: $passw \nEmail: $senderEmail";

    	if(mail($recipient, $subject, $mailBody, "From: $sender <$senderEmail>")){
		header('Location: /final_project/Mail.php');
	}

    	$thankYou="<p>Thank you! Your message has been sent.</p>";

}	


	echo "
	<html>
	<head><title> Registration Form </title>
	<body>
	<center>
	<form method=\"post\" action=\"\">
	<table>
	Name:&nbsp &nbsp &nbsp <input type=\"text\" name=\"personname\">
	<tr><td>Username: <input type=\"text\" name=\"username\"></td></tr>
	<tr><td>Password:&nbsp <input type=\"password\" name=\"password\"></td></tr>
	<tr><td>Email id:&nbsp &nbsp <input type=\"text\" name=\"senderEmail\"></td></tr>
	<tr><td><input type=\"submit\" name=\"submit\" value=\"Register\"></td></tr>
	</table></form>
	</body></head>
	</html>
	";

 
?>

