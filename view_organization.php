<?php
include('includes.php');

if(isset($_GET['org_id'])) {
	$org_id = $mysqli->real_escape_string($_GET['org_id']);
	$query = "SELECT * FROM Organization WHERE OrganizationID = $org_id";

	$result = $mysqli->query($query);
	$org = $result->fetch_assoc();

	$org_name = $org['OrganizationName'];

	$query = "SELECT * FROM VolunteerOpportunities WHERE OrganizationName = '$org_name'";
	$result = $mysqli->query($query);

	while($row = $result->fetch_assoc()) {
		$events[] = $row;
	}
}
include('header.php');

?>


<html>
<head>
	<title></title>
</head>
<a href="index.php">Back</a></br>
<body>
	Organization Name: <?=$org['OrganizationName'] ?><br />
	Organization Address: <?= $org['OrganizationAddress'] ?><br />
	<br />
	Organization Events
	<?php if(count($events) > 0) : ?>
		<table border="1">
			<tr>
				<th>Name</th>
				<th>Date</th>
				<th>Capacity</th>
				<th>Description</th>
			</tr>

	
		<?php foreach($events as $index => $data) : ?>
			<tr>
				<th><?= $events[$index]['VolOpprtName']?></th>
				<th><?= $events[$index]['VolOpprtDate']?></th>
				<th><?= $events[$index]['VolOpprtNumNeed']?></th>
				<th><?= $events[$index]['VolOpprtDescription']?></th>
			</tr>
		<?php endforeach ?>
	<?php else : ?>
		<b>There are no events for this organization.</b>
	<?php endif ?>
	</table>
</body>
</html>

<?php include("footer.php"); ?>
