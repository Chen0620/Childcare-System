<?php
$mysqli = new mysqli("dbhost-mysql.cs.missouri.edu","cs4320f12grp8","Di2FjVNN","cs4320f12grp8");
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
	}

$from_date = $_GET['start'];
$to_date   = $_GET['end'];

$from_date = date('Y-m-d', $from_date);
$to_date   = date('Y-m-d', $to_date);

$query = "SELECT VolOpprtName, VolOpprtDate, VolOpprtID FROM VolunteerOpportunities WHERE VolOpprtDate >= '$from_date' AND VolOpprtDate <= '$to_date'";
$result = $mysqli->query($query);

while($entry = $result->fetch_assoc()) {
	$events[] = $entry; 
}


foreach($events as $index => $data) {
	$events[$index]['title'] = $events[$index]['VolOpprtName'];
	$events[$index]['start'] = $events[$index]['VolOpprtDate'];
 	$events[$index]['id']    = $events[$index]['VolOpprtID']; 

	unset($events[$index]['VolOpprtName']);
	unset($events[$index]['VolOpprtDate']);
	unset($events[$index]['VolOpprtID']);
}

echo json_encode($events);
?>
