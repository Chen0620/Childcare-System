<?php
	session_start();
	include("db_conncet.php");
	include('includes.php');

	if($_GET['error'] == 1) {
		$_SESSION['errorFlag'] = true;
		$_SESSION['error[1]'] = 'You do not have permission to access that page.';

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

			});
		</script>
	<style>
	    .fc-event-inner {
	        cursor : pointer;
	    }
	</style>
<table>
<tr>
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
				<form action="test.php" method="POST">
					<label for="username">Username: </label><input type="text" name="username" id="username"><br />
					<label for="password">Password: </label><input type="password" name="password" id="password"><br />
					<input type="submit" value="Login!" class="btn btn-large btn-primary"/>
				</form>
			</div>
	    </div>
</tr>
<tr>
	    <? if($_SESSION['errorFlag'] != 1) : ?>
		    <div class="span10">
		    	<h2>Welcome to Exploration!  Please login or click an event to see more information!</h2>
		    	<div id='calendar'></div>
		   
		    </div>
	     <? endif ?>
	  </div>
</tr>
</table>
</div>
	</body>
</html>
