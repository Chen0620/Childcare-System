<?php
include('includes.php');
include('header.php');
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

?>
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
<a href="donations.php">Back To Donations</a>
<?php include("footer.php"); ?>