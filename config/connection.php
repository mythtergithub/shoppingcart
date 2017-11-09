<?php

	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbse = "shoppingcart";
	
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	
	$LINK = new mysqli($host, $user, $pass, $dbse);
	
	if ($LINK->connect_error) {
		die("Connection failed: " . $LINK->connect_error);
	}

?>