<?php
	include("header.php");
?>

<form method="POST" ACTION="org.php">
	<table>
		<tr><th><b>Update Organization</b></th></tr>
		<tr>	
			<td><label for="ooname"><b>Organization Name:</b></label></td>
			<td><input id="ooname" name="ooname" type="text"/><font color="red">*</font></td>
		</tr>
		<tr>
			<td><label for="ooadd"><b>Organization Address:</b></label></td>
			<td><input id="ooadd" name="ooadd" type="text"/><font color="red">*</font></td>
		</tr>
		<tr>
			<td><input type="submit" value="Update" name="update"></td>
		</tr>
	</table>
</form>
<?php include("footer.php"); ?>