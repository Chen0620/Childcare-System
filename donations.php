<?php
include('includes.php');

if($_SESSION['user_type_id'] != 3) {
    session_destroy();
    header('Location: index.php?error=1');
}

$today = date('Y-m-d');

$year  = mktime(0, 0, 0, date("m"), date("d"),   date("Y") - 1);
$year  = date('Y-m-d', $year);

//Populate Member Selecter
$query = "  SELECT
                CONCAT_WS(' ', MemberFname, MemberLname) as 'member_name',
                MemberID
            FROM
                Member m

            GROUP BY MemberID";
            
$result = $mysqli->query($query);

while($entry = $result->fetch_assoc()) {
    $users[] = $entry; 
}

if(count($_POST) > 0) {
    
    $method = $_POST['method'];
    
    switch ($method) {
        case 'member':
            $data = explode("/", $_POST['member_info']);
            $member_id   = $mysqli->real_escape_string($data[0]);
            $member_name = $mysqli->real_escape_string($data[1]);
            $amount      = $mysqli->real_escape_string($_POST['amount']);
            $pay_type    = $mysqli->real_escape_string($_POST['pay_type']);
            
            $query = "  INSERT INTO
                            donations
                            (member_id, donation_amount, payment_type, donor_name)
                        VALUES
                            ($member_id, $amount, '$pay_type', '$member_name')";
            break;
        case 'nonmember':
            $donor_name = $mysqli->real_escape_string($_POST['donor_name']);
            $amount     = $mysqli->real_escape_string($_POST['amount']);
            $pay_type   = $mysqli->real_escape_string($_POST['pay_type']);
            
            $query = "  INSERT INTO
                            donations
                            (donation_amount, payment_type, donor_name)
                        VALUES
                            ($amount, '$pay_type', '$donor_name')";
            break;
        case 'anonymous':
            $donor_name = 'Anonymous';
            $amount     = $mysqli->real_escape_string($_POST['amount']);
            $pay_type   = $mysqli->real_escape_string($_POST['pay_type']);
            
            $query = "  INSERT INTO
                            donations
                            (donation_amount, payment_type)
                        VALUES
                            ($amount, '$pay_type')";
            break;
        default:
            echo 'Something went wrong!';
            exit();
    }
    
    $result = $mysqli->query($query);
}

include('header.php');
?>
<script>
    $(document).ready(function() {
       $('#nonmember').hide();
       $('#member').hide();
       
        $('[name="type"]').change(function() {
            var hash = '#';
            var selected = $('input[name="type"]:checked').val();
            var table = hash.concat(selected);
            
            $('#nonmember').hide();
            $('#anonymous').hide();
            $('#member').hide();
            $(table).show();
        })

    });
</script>

<div id="donation" border="1">
<form name="donation_type">
    <p>Donation Type:</p>
    <input type="radio" name="type" value="anonymous" checked> Anonymous
    <input type="radio" name="type" value="member"> Member
    <input type="radio" name="type" value="nonmember"> Non-member
</form>

<form name="donation_form" id="nonmember" method="POST">
    <input type="hidden" name="method" value="nonmember" />
    Donor Name:<input type="text" name="donor_name" /><br />
    Donation Amount: <input type="text" name="amount" /><br />
    <input type="radio"  name="pay_type" value="cash">Cash<br />
    <input type="radio" name="pay_type" value="credit">Check<br />
    <input type="submit" />
</form>

<form name="donation_form" id="anonymous" method="POST">
    <input type="hidden" name="method" value="anonymous" />
    Donation Amount: <input type="text" name="amount" /><br />
    <input type="radio"  name="pay_type" value="cash">Cash<br />
    <input type="radio" name="pay_type" value="credit">Check<br />
    <input type="submit" />
</form>
</div>

<form name="donation_form" id="member" method="POST">
    <input type="hidden" name="method" value="member" />
    Member: <select name="member_info">
                <?foreach ($users as $index => $data) : ?>
                    <option value="<?= $data['MemberID'] ?>/<?= $data['member_name']?>"><?= $data['member_name'] ?></option>
                <?endforeach?>
            </select><br />
    Donation Amount: <input type="text" name="amount" /><br />
    <input type="radio" name="pay_type" value="cash">Cash<br />
    <input type="radio" name="pay_type" value="credit">Check<br />
    <input type="submit" />
</form>

<?php include("footer.php"); ?>