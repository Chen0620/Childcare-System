<?php
include('includes.php');
include('header.php');

$today = date('Y-m-d');

$year  = mktime(0, 0, 0, date("m"), date("d"),   date("Y") - 1);
$year  = date('Y-m-d', $year);

$query = "  SELECT
                username,
                user_id
            FROM
                users";
            
$result = $mysqli->query($query);

while($entry = $result->fetch_assoc()) {
    $users[] = $entry; 
}

if(isset($_GET['user_id'])) {
	$user_id = $mysqli->real_escape_string($_GET['user_id']);

	$query = "SELECT username FROM users WHERE user_id = $user_id";
	$result = $mysqli->query($query);

	$user = $result->fetch_assoc();

	$query = "SELECT * FROM payroll WHERE user_id = $user_id";

	$result = $mysqli->query($query);

	while($entry = $result->fetch_assoc()) {
    	$payroll[] = $entry; 
	}
}

if(isset($_GET['pay_user_id'])) {
	$user_id = $mysqli->real_escape_string($_GET['pay_user_id']);
	$amount  = $mysqli->real_escape_string($_GET['amount']);
	$query = "INSERT INTO payroll (user_id, payroll_amount) VALUES ($user_id, $amount)";
	$mysqli->query($query);

	echo '<script>alert("Payroll data submitted!");</script>';
}
?>

<html>
<head>
	<title>Payroll</title>
</head>
<body>
	<h2>Payroll</h2>



	<div id="payroll_div">
		<form>
			<b>Submit Paycheck:</b>  <br />
			User:
			<select name="pay_user_id">
				<?php foreach($users as $index => $data) : ?>
					<option value="<?= $data['user_id'] ?>"><?= $data['username'] ?></option>
				<?php endforeach ?>
			</select><br />
			Amount: <input type="text" name="amount"><br />
			<input type="submit" value="Pay!">
		</form>
	 </div>
	 <form>
		<b>View A User's Pay-history.</b> <br />
		<select name="user_id">
			<?php foreach($users as $index => $data) : ?>
				<option value="<?= $data['user_id'] ?>"><?= $data['username'] ?></option>
			<?php endforeach ?>
		</select>
		<input type="submit" value="Submit!">
	</form>
	<?php if(isset($_GET['user_id'])) : ?>
		<b>Viewing payroll for <?= $user['username'] ?>.</b><br />
		<table border="1">
			<tr>
				<th>Amount</th>
				<th>Date</th>
			</tr>
			<?php foreach($payroll as $index => $data) : ?>
				<tr>
					<td><?= $data['payroll_amount'] ?></td>
					<td><?= $data['date_paid'] ?></td>
				</tr>
			<?php endforeach ?>
	<?php endif ?>
</body>
</html>
