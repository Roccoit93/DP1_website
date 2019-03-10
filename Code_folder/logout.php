<?php
require_once 'session.php';
require_once 'cookie.php';

if(!isset($_SESSION['user243917'])){
	$res='<h2>You are not logged in! Timeout Expired!</h2>'
	.'<p class="darkgray">Click <a href="index.php">here</a> to go to Home page!</p>';
}
else{
		destroySession();
		$res='<h2>You have been successfully <span class="darkgray">logged out</span>.</h2>'
				.'<p class="darkgray">Did you make a mistake? Click <a href="index.php">here</a> to go to Home page!</p>';
			}
echo"
<!DOCTYPE html>
<html lang='en'>
<head>
<title>logout</title>
</head>

<div id='main'>";
 echo $res;
 echo"
</div>
</html>";
?>
