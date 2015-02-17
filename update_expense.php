<?php
include 'includes.php';

if($_SESSION['user_type_id'] != 4) {
	header('Location: index.php?error=1');
}

if(isset($_GET['expense_id'])) {
	$expense_id = $mysqli->real_escape_string($_GET['expense_id']);

	$query = "	SELECT
					*
				FROM
					expenses
				WHERE
					expense_id = $expense_id";

	$result = $mysqli->query($query);
	$expense = $result->fetch_assoc();
}

if(isset($_POST['expense_id'])) {
	$amount       = $mysqli->real_escape_string($_POST['amount']);
	$check_number = $mysqli->real_escape_string($_POST['check_number']);
	$description  = $mysqli->real_escape_string($_POST['description']);
	$date         = $mysqli->real_escape_string($_POST['date']);
	$expense_id   = $mysqli->real_escape_string($_POST['expense_id']);

	$query = "	UPDATE
					expenses
				SET
					amount = $amount,
					check_number = $check_number,
					description = '$description',
					expense_date = '$date'
				WHERE
					expense_id = $expense_id";
	$mysqli->query($query);

	header('Location: accounting.php?update=1');
}
 ?>


<!DOCTYPE html>
<html>
	<head>
		<title>Update Expense</title>
		<script>
			$(document).ready(function() {
				$('#date').datepicker({dateFormat: 'yy-mm-dd'});
			});
		</script>
	</head>

<form method="POST">
	Amount: <input type="text" name="amount" value="<?= $expense['amount'] ?>"><br />
	Check #: <input type="text" name="check_number" value="<?= $expense['check_number'] ?>"><br />
	Description: <input type="text" name="description" value="<?= $expense['description'] ?>"><br />
	Expense Date: <input type="text" id="date" name="date" value="<?= $expense['expense_date'] ?>"><br />
	<input type="hidden" name="expense_id" value="<?= $expense_id ?>" />
	<input type="submit">
</form>

<a href="accounting.php">Back To Accounting</a>
<?php include("footer.php"); ?>
