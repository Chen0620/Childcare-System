<?php

include('includes.php');
include('header.php');

if($_SESSION['user_type_id'] != 3) {
	session_destroy();
	header('Location: index.php?error=1');
}

$today = date('Y-m-d');

$year  = mktime(0, 0, 0, date("m"), date("d"),   date("Y") - 1);
$year  = date('Y-m-d', $year);

//Populate view_Member Selecter if they have donations in the donation table
$query = "  SELECT
                CONCAT_WS(' ', MemberFname, MemberLname) as 'member_name',
                MemberID
            FROM
                Member m
                JOIN donations d
                    ON m.MemberID = d.member_id
            GROUP BY MemberID";
            
$result = $mysqli->query($query);

while($entry = $result->fetch_assoc()) {
    $donation_users[] = $entry; 
}

if(count($_GET) > 0) {
	$member_id = $mysqli->real_escape_string($_GET['member_id']);
	$from_date = $mysqli->real_escape_string($_GET['from_date']);
	$to_date = $mysqli->real_escape_string($_GET['to_date']);

	$query = "SELECT * FROM donations WHERE member_id = $member_id AND donation_date > '$from_date' AND donation_date < '$to_date'";

	$result = $mysqli->query($query);

	while($entry = $result->fetch_assoc()) {
	    $records[] = $entry; 
	}

	foreach($records as $index => $data) {
	    $total_donations += $data['donation_amount'];
	}
}

?>

<html>
	<head>
		<title>IRS Report</title>
	</head>
	<body>
		<div id="irs">
			<h1>IRS Report</h1>
			View Donations For A Member<br />
			<form name="view_donations" id="view_donations" method="GET">
			    <select  name="member_id">
			                <?foreach ($donation_users as $index => $data) : ?>
			                    <option value="<?= $data['MemberID']?>"><?= $data['member_name'] ?></option>
			                <?endforeach?>
			    </select><br />

			    From Date:<input type="text" id="from_date" name="from_date" value="<?= $year ?>"/><br />
			    To Date:<input type="text" id="to_date" name="to_date" value="<?= $today ?>"/><br />
			    <input type="submit" />
			</form>

			<? if(count($_GET) > 0) : ?>
				Showing donations for <b><?=$records[0]['donor_name'] ?></b> from <?= $from_date . ' to ' . $to_date ?>.
				<table border="1">
				    <thead>
				        <tr>
				            <th>Donation ID</th>
				            <th>Donation Amount</th>
				            <th>Payment Method</th>
				            <th>Donation Date</th>
				        </tr>
				    </thead>
				    <tbody>
				        <?foreach($records as $index => $data) : ?>
				            <tr>
				                <td><?= $data['donation_id'] ?></td>
				                <td><?= $data['donation_amount'] ?></td>
				                <td><?= $data['payment_type'] ?></td>
				                <td><?= $data['donation_date'] ?></td>
				            </tr>
				        <?endforeach?>
				    </tbody>
				</table>
				Total Donations: $<?= $total_donations ?><br />
			<? endif ?>
		</div>
	</body>
</html>

<?php include("footer.php"); ?>