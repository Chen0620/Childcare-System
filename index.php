<?php
	session_start();
	include("db_connect.php");
	include('includes.php');

	if($_GET['error'] == 1) {
		$_SESSION['errorFlag'] = true;
		$_SESSION['error[1]'] = 'You do not have permission to access that page.';

	}

	$query = "SELECT OrganizationID, OrganizationName FROM Organization";

	$result = $mysqli->query($query);

	while($entry = $result->fetch_assoc()) {
	    $organizations[] = $entry; 
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Exploration Login</title>
	</head>

	<body>
		<script type='text/javascript' src='./fullcalendar/fullcalendar.js'></script>
		<link rel='stylesheet' type='text/css' href='./fullcalendar/fullcalendar.css' />
	    <script>
	    	$(document).ready(function() {

			    // page is now ready, initialize the calendar...

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

			    if($('.alert').length > 0) {
			    	$('#cal_div').hide();
			    }

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
	<style>
	    .fc-event-inner {
	        cursor : pointer;
	    }
	</style>

<div class="container-fluid">
  <div class="row-fluid">
	    <div class="span2">
	      	<div class="container">
				<h2>Login</h2>
				<?php

					include("error.php");
					if(strcmp($_SESSION['username'],'')!=0)
					{
						//echo "Hello $_SESSION[username]! You're logged in as $_SESSION[usertype].<br />";
						header("Location:calendar.php");
						
					}
				?>
				<form action="login.php" method="POST">
					<label for="username">Username: </label><input type="text" name="username" id="username"><br />
					<label for="password">Password: </label><input type="password" name="password" id="password"><br />
					<input type="submit" value="Login!" class="btn btn-large btn-primary"/>
				</form>
				Organizations: <br />
				<?php foreach($organizations as $index => $data) : ?>
					<a href="view_organization.php?org_id=<?= $data['OrganizationID'] ?>"><?= $data['OrganizationName'] ?></a><br />
				<?php endforeach ?>
			</div>
	    </div>
		    <div id="cal_div" class="span10">
		    	<h2>Welcome to Exploration!</h2><br />
		    	<h4>Please login or click an event to see more information!</h4>
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
	</body>
</html>

<?php include("footer.php"); ?>