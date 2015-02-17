<?php

include('header.php');
$rows = array();

if($_SESSION['user_type_id'] != 1) {
    header('Location: index.php?error=1');
}

$query = "  SELECT
                u.user_id,
                u.username,
                ut.user_type
            FROM
                users u
                JOIN user_type ut
                    ON u.user_type = ut.user_type_id
            ORDER BY u.user_id";

            
$result = $mysqli->query($query);

while($entry = $result->fetch_assoc()) {
    $rows[] = $entry; 
}

?>
<h1>User Management</h1>
<a href="register.php">Add User</a>
<table border="1">
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>User Type</th>
        <th>Options</th>
    </tr>
<?foreach($rows as $data) : ?>
    <tr>
        <td><?= $data['user_id'] ?></td>
        <td><?= $data['username'] ?></td>
        <td><?= $data['user_type'] ?></td>
        <td>
            <form method="GET" action="edit_user_info.php">
                <input type="submit" value="Edit User" name="update">
                <input type="hidden" name="user_id" value="<?= $data['user_id'] ?>">
            </form>
        </td>
    </tr>
<?endforeach?>
</table>
<?php include("footer.php"); ?>