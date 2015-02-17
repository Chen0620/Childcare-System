<?php

include('includes.php');
include("header.php");

if(isset($_GET['update_info'])) {
    $username  = $_GET['username'];
    $user_type = $_GET['user_type'];
    $user_id   = $_GET['user_id'];
    
    $username  = $mysqli->real_escape_string($username);
    $user_type = $mysqli->real_escape_string($user_type);
    $user_id   = $mysqli->real_escape_string($user_id);
    
    $query = "  UPDATE
                    users
                SET
                    username =  '" . $username . "',
                    user_type = " . $user_type . "
                WHERE
                    user_id =  " . $user_id;
               
    $mysqli->query($query);
    
    header('Location: view_users.php');
}

if(isset($_GET['delete'])) {
    $user_id = $_GET['user_id'];
    $user_id   = $mysqli->real_escape_string($user_id);
    
    $query = "  DELETE FROM
                    users
                WHERE
                    user_id = " . $user_id;
                    
    $mysqli->query($query);
    
    header('Location: view_users.php');
}

$user_types = array();
$user_id = $_GET['user_id'];
$user_id = $mysqli->real_escape_string($user_id);

$query = "  SELECT
                u.user_id,
                u.username,
                ut.user_type
            FROM
                users u
                JOIN user_type ut
                    ON u.user_type = ut.user_type_id
            WHERE
                u.user_id = " . $user_id;
                
$result = $mysqli->query($query);
$row = $result->fetch_assoc();


$query = "  SELECT
                *
            FROM
                user_type";
$result = $mysqli->query($query);

while($entry = $result->fetch_assoc()) {
    $user_types[] = $entry; 
}

?>

Current Information <br />
User Name: <?= $row['username'] ?> <br />
User Type: <?= $row['user_type'] ?> <br />
<br />
Update Information <br />
<form method="GET" action="#">
    <input type="text" name="username" value=" <?= $row['username'] ?>">
    <select name="user_type">
        <? foreach($user_types as $index => $data) : ?>
            <option value="<?= $data['user_type_id'] ?>"><?= $data['user_type']; ?></option>
        <?endforeach?>
    </select>
    <input type="hidden" name="update_info" value="update" />
    <input type="hidden" name="user_id" value="<?= $user_id ?>" />
    <input type="submit" value="Update!" />
</form>
<form method="GET" action="#">
    <input type="hidden" name="user_id" value="<?= $user_id ?>" />
    <input type="submit" name="delete" value="Delete!" />
</form>
<?php include("footer.php"); ?>