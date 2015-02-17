<?php
	include("includes.php");
	include("header.php");

?>

<form method="POST" ACTION="teacher.php">
	<table>
		<tr><th><b>Update Teacher Record</b></th><th>(Only fill in the fields need to be updated.)</th></tr>
		<tr>	
			<td><label for="ename"><b>Teacher Name:</b></label></td>
			<td><input id="ename" name="ename" type="text"/>
		</tr>
		<tr>	
			<td><label for="eroom"><b>Room:</b></label></td>
			<td><input id="eroom" name="eroom" type="text"/>
		</tr>
		<tr>
			<td><input type="submit" value="Update" name="updateteacher"></td>
		</tr>
	</table>
</form>
<?php include("footer.php"); ?>