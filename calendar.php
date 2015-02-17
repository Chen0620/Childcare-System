<?php
include('includes.php');
include('header.php');
$user_type = $_SESSION['usertype'];

echo '<h1>Exploration!</h1>';

?>

<style>
    .fc-event-inner {
        cursor : pointer;
    }
</style>
        <script type='text/javascript' src='./fullcalendar/fullcalendar.js'></script>
        <link rel='stylesheet' type='text/css' href='./fullcalendar/fullcalendar.css' />
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script>
            $(document).ready(function() {

                $('#calendar').fullCalendar({
                    events: 'calGetEvents.php',

                    eventClick: function(event, jsObj, view) {
                        window.location = 'viewCalEvent.php?event_id=' + event.id;
                    }
                })

                $('#vol_cal').fullCalendar({
                    events: 'calGetVolEvents.php',

                    eventClick: function(event, jsObj, view) {
                        window.location = 'viewCalEvent.php?event_id=' + event.id;
                    }
                })

                $('#vol_cal').hide();

                $('[name="cal_view"]').change(function() {
                    var selected = $('input[name="cal_view"]:checked').val();
                    var cal = '#' + selected;

                    $('#calendar').hide();
                    $('#vol_cal').hide();
                    $(cal).show();

                    if(cal === '#vol_cal') {
                        $('.fc-button-next').click();
                        $('.fc-button-prev').click();
                    }
                })


            });
        </script>

<html>
<head>
    <title></title>
</head>
<body>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <?php 
            switch($user_type) {
                case 'admin':
                    $message = 'You\'re currently logged in as an Administrator.';
                    echo '<p>Navigation</p><br />';
                    echo '<a href="view_users.php">User Management</a><br />';
                    echo '<a href="logout.php">Logout</a>';
                    break;
                case 'office_manager':
                    $message = 'You\'re currently logged in as an Office Manager.';
                    echo '<p>Navigation</p><br />';
                    echo '<a href="manageMember.php">Members</a><br />';
                    echo '<a href="Event.php">Events</a><br />';
                    echo '<a href="vol.php">Volunteer Opportunities</a><br />';
                    //echo '<a href="logout.php">Manage Employees</a><br/>';
                    echo '<a href="org.php">Organizations</a><br />';
                    echo '<a href="child.php">Children Records</a>';
                    break;
                case 'rec_treasurer':
                    $message = 'You\'re currently logged in as a Recieving Treasurer.';
                    echo '<p>Navigation</p><br />';
                    echo '<a href="donations.php">Donations</a><br />';
                    echo '<a href="irs.php">IRS Report</a><br />';
                    break;
                case 'accountant':
                    $message = 'You\'re currently logged in as an Accountant.';
                    echo '<p>Navigation</p><br />';
                    echo '<a href="accounting.php">Accounting</a><br />';
                    echo '<a href="payroll.php">Create Payroll Checks</a>';
                    break;
                case'teacher':
                    $message = 'You\'re currently logged in as a Teacher.';
                    echo '<p>Navigation</p><br />';
                    echo '<a href="child.php">Family-Child Management</a><br />';
                    echo '<a href="childChildcare.php">Teacher-Child Management</a><br />';
                    echo '<a href="">Tuition(Family Payment)</a><br />';
                    echo '<a href="teacher.php">Teacher Information</a>';
                    break;
				case'member':
                    $message = 'You\'re currently logged in as a Member.';
                    echo '<p>Navigation</p><br />';
                    echo '<a href="manageMember.php">Update member date</a><br />';
                    echo '<a href="vol.php">Manage Volunteer-Member Event</a><br />';

                    break;
                default:
                    echo '<p>Navigation</p><br />';
                    echo '<a href="logout.php">Logout</a>';
            } ?>
        </div>
        <div class="span10">
                <h2>Welcome to Exploration!</h2><br />
                <h4>Click an event to see more information!</h4>
                <form>
                    <input type="radio" name="cal_view" value="calendar" checked>Exploration Calendar
                    <input type="radio" name="cal_view" value="vol_cal">Volunteer Calendar<br />
                </form>
				<a href="search.php"><b>Go to Search Events!!</b></a> 
                <div id="calendar"></div>
                <div id="vol_cal"></div>
            </div>
        </div>
      </div>
</div>
</body>
</html>
<?php include("footer.php"); ?>
