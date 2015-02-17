<?php
include('includes.php');
include('header.php');
$event_id = $mysqli->real_escape_string($_GET['event_id']);

$query = "SELECT * FROM EventOfExploration WHERE EventID = $event_id";
$result = $mysqli->query($query);

$entry = $result->fetch_assoc();

?>

<html>
	<head>
		<title>View Calendar Event</title>
	</head>
	<body>
		Event Name: <?= $entry['EventName'] ?><br />
		Date: <?= $entry['EventDate'] ?><br />
		Time: <?= $entry['EventTime'] ?><br />
		Room #: <?= $entry['EventRoom'] ?><br />
		Description: <?= $entry['EventDescription'] ?><br />
		Duration: <?= $entry['EventDuration'] ?><br />
		<a href="index.php">Back To Calendar</a>
	</body>
</html>
<?php include("footer.php"); ?>