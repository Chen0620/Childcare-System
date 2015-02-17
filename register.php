<?php

// if($_SESSION['user_type_id'] != 1) {
// 	header('Location: index.php?error=1');
// }

include 'includes.php';
include 'header.php';

if(isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user_type = $_POST['user_type'];

	$hash = makeHash($password, $username);
	$hash = $mysqli->real_escape_string($hash);

	$query = "INSERT INTO authentication (hash) VALUES ('".$hash."')";
	$mysqli->query($query);
	$auth_id = $mysqli->insert_id;

	$username = $mysqli->real_escape_string($username);
	$query = "INSERT INTO users (username, user_type, authentication_id) VALUES ('$username', $user_type, $auth_id)";
	$mysqli->query($query);
	
	header('Location: view_users.php');
}

	function makeHash($password, $username) {
		return crypt($password, $username);
	}
?>

<html>
	<head>Registration</head>
	<body>
		<h2>Add User</h2>
		<form method="POST" action="#">
			Username: <input type="text" name="username"><br />
			Password: <input type="password" name="password"><br />
			User Type: <select name="user_type" id="user_type">
							<option value="1">Admin</option>
							<option value="2">Office Manager</option>
							<option value="3">Receiving Treasurer</option>
							<option value="4">Accountant</option>
							<option value="5">Teacher</option>
							<option value="5">Member</option>
						</select>
			<input type="submit" value="Register">
		</form>
	</body>
</html>
<?php include("footer.php"); ?>