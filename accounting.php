<?php
include 'includes.php';
include 'header.php';

if($_SESSION['user_type_id'] != 4) {
	session_destroy();
	header('Location: index.php?error=1');
}

if($_GET['update'] == 1) {
	echo "<script>alert('Update successful!');</script>";
}

//Get donations for the past week/month/year
$today = date('Y-m-d');

$week  = mktime(0, 0, 0, date("m"), date("d") - 7, date("Y"));
$month = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
$year  = mktime(0, 0, 0, date("m"), date("d"),   date("Y") - 1);

$week  = date('Y-m-d', $week);
$month = date('Y-m-d', $month); 
$year  = date('Y-m-d', $year);

$week_donation  = 0;
$month_donation = 0;
$year_donation  = 0;

$week_query = "	SELECT
					donation_amount
				FROM
					donations
				WHERE
					donation_date > '$week'
					AND donation_date < NOW()";

$result = $mysqli->query($week_query);

while($data = $result->fetch_assoc()) {
	$week_donation += $data['donation_amount'];
}

$month_query = "	SELECT
					donation_amount
				FROM
					donations
				WHERE
					donation_date > '$month'
					AND donation_date < NOW()";

$result = $mysqli->query($month_query);

while($data = $result->fetch_assoc()) {
	$month_donation += $data['donation_amount'];
}

$year_query = "	SELECT
					donation_amount
				FROM
					donations
				WHERE
					donation_date > '$year'
					AND donation_date < NOW()";

$result = $mysqli->query($year_query);

while($data = $result->fetch_assoc()) {
	$year_donation += $data['donation_amount'];
}

//Sets the date picker dates to GET or today and a month ago if no submit has been made
if(count($_GET) != 2) {
	$from_date = $month;
	$to_date   = $today;
} else {
	$from_date = $mysqli->real_escape_string($_GET['from_date']);
	$to_date   = $mysqli->real_escape_string($_GET['to_date']);
}

//Pull months worth of expenses as default, takes in changing date values on submit
$query = "	SELECT
				expense_id,
				amount,
				check_number,
				description,
				expense_date
			FROM
				expenses
			WHERE
				expense_date > '$from_date'
				AND expense_date <= '$to_date'";

$result = $mysqli->query($query);

while($data = $result->fetch_assoc()) {
	$expenses[] = $data;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Accouting</title>
	</head>
	<body>
		<script>
			$(document).ready(function() {
				$('#from_date').datepicker({dateFormat: 'yy-mm-dd'});
				$('#to_date').datepicker({dateFormat: 'yy-mm-dd'});

			});
		</script>

		<div id="donation">
		<h1> Accounting </h1>
		<table border="1">
			<tr>
				<th>Donations in the last...</th>
				<th>Amount</th>
			</tr>
			<tr>
				<th>Week</th>
				<td>$<?= $week_donation ?></td>
			</tr>
			<tr>
				<th>Month</th>
				<td>$<?= $month_donation ?></td>
			</tr>
			<tr>
				<th>Year</th>
				<td>$<?= $year_donation ?></td>
			</tr>
		</table>
		</div>
		<br />
		<div id="irs">
		View Expenses
		<form id="view_expenses" method="get">
			From Date:<input type="text" id="from_date" name="from_date" value="<?= $from_date ?>"/>
			To Date:<input type="text" id="to_date" name="to_date" value="<?= $to_date ?>"/>
			<input type="submit" />
		</form>
		<br />
		<?if(count($_GET) > 1) : ?>
			<table border="1" text-align="center">
				<tr>
					<th>Check Number</th>
					<th>Amount</th>
					<th>Description</th>
					<th>Date</th>
					<th>Administration</th>
				</tr>
				<? foreach($expenses as $index => $data) : ?>
					<tr>
						<td><?= $data['check_number'] ?></td>
						<td>$<?= $data['amount'] ?></td>
						<td><?= $data['description'] ?></td>
						<td><?= $data['expense_date'] ?></td>
						<td>
							<form id="<?= $data['expense_id'] ?>" method="get" action="update_expense.php">
								<input type="hidden" name="expense_id" value="<?= $data['expense_id'] ?>" />
								<input type="submit" value="Edit" />
							</form>
						</td>
					</tr>
				<? endforeach ?>
			</table>
		<? endif ?>
		</div>
	</body>
</html>
<?php include("footer.php"); ?>