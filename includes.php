<?php
$link=mysqli_connect("dbhost-mysql.cs.missouri.edu","cs4320f12grp8","Di2FjVNN","cs4320f12grp8") or die("Could not connect:" .mysqli_connection_error());
//echo "Connected successfully";
//test query
//$query="INSERT INTO test VALUES (2399933)";
//$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());

$mysqli = new mysqli("dbhost-mysql.cs.missouri.edu","cs4320f12grp8","Di2FjVNN","cs4320f12grp8");
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
}

function print_array($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

session_start();
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">