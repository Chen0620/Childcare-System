<?php
	include("header.php");
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"></script>
<script>
	$(document).ready(function() {
		$('#edate').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>

<form method="POST" ACTION="Event.php">
	<table>
		<tr><th><b>Update Event of Exploration (Only fill in the fields need to be updated.)</b></th></tr>
		<tr>	
			<td><label for="ename"><b>Event Name:</b></label></td>
			<td><input id="ename" name="ename" type="text"/>
		</tr>
		<tr>
			<td><label for="edate"><b>Event Date:</b></label></td>
			<td>
				<input type="text" id="edate" name="edate" />
			</td>
		</tr>
		<tr>
			<td><label for="est"><b>Event Start Time:</b></label></td>
			<td>
				<input id="esh" name="esh" type="text"/> <b>:</b> <input id="esm" name="esm" type="text"/>
			</td>
		</tr>
		<tr>
			<td><label for="eroom"><b>Event Room:</b></label></td>
			<td><input id="eroom" name="eroom" type="text"/>
		</tr>
		<tr>
			<td><label for="etime"><b>Event Duration:</b></label></td>
			<td><input id="ehour" name="ehour" type="text"/> Hours <input id="emin" name="emin" type="text"/> Minutes</td>
		</tr>
		<tr>
			<td><label for="edesc"><b>Event Description:</b></label></td>
			<td><textarea name="edesc"></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" value="Update" name="updateevent"></td>
		</tr>
	</table>
</form>
<?php include("footer.php"); ?>