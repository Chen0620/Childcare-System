<?php
	include('db_connect.php');
	$query = "SELECT * FROM user_type";
	$result = $mysqli->query($query);
	$types = $result->fetch_assoc;
	print_r($types);
	echo "You are currently logged in as the ";