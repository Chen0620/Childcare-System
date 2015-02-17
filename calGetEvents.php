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

$query = "SELECT EventName, EventDate, EventID, EventTime FROM EventOfExploration WHERE EventDate >= '$from_date' AND EventDate <= '$to_date'";

$result = $mysqli->query($query);

while($entry = $result->fetch_assoc()) {
	$events[] = $entry; 
}

foreach($events as $index => $data) {
	$events[$index]['title'] = $events[$index]['EventName'];
	$events[$index]['start'] = $events[$index]['EventDate'] . ' ' . $events[$index]['EventTime'];
 	$events[$index]['id']    = $events[$index]['EventID']; 

	$events[$index]['allDay'] = false;

	unset($events[$index]['EventName']);
	unset($events[$index]['EventDate']);
	unset($events[$index]['EventID']);
}

echo json_encode($events);
?>
