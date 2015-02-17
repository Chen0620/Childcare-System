<?php
	include("header.php");
	include ("includes.php");
	
	if(strcmp($_SESSION['uid'],'')==0)
	{
		$_SESSION['errorFlag']=1;
		$_SESSION['error[0]']='No volunteer opportunity has been selected.';
		header("Location:vol.php");
	}
?>
<script>
	$(document).ready(function() {
		$('#edate').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<form method="POST" ACTION="vol.php">
	<table>
		<tr><th><b>Update Volunteer Event</b></th><th>(only fill in the blanks you want to update)</th></tr>
		<tr>	
			<td><label for="ename"><b>Event Name:</b></label></td>
			<td><input id="ename" name="ename" type="text"/><font color="red">*</font></td>
		</tr>
		<tr>
			<td><label for="edate"><b>Event Date:</b></label></td>
			<td><input type="text" id="edate" name="edate" /></td>
		</tr>
		<tr>
			<td><label for="enum"><b>Number of Volunteer Needed:</b></label></td>
			<td><input id="enum" name="enum" type="text"/><font color="red">*</font></td>
		</tr>
		<tr>
			<td><label for="edesc"><b>Event Description:</b></label></td>
			<td><textarea name="edesc"></textarea></td>
		</tr>
		<tr>
			<td><label for="eorg"><b>Organization:</b></label></td>
			<td><?php
				$query="SELECT OrganizationName FROM Organization";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				echo "<select name='eorg'><option value=''></option>";
				while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
				{
					foreach($line as $col_value)
						echo "<option value='$col_value'>$col_value</option>";
				}
			echo "</select>";
			?><font color="red">*</font></td>
		</tr>
		<tr>
			<td><input type="submit" value="Update" name="updateevent"></td>
		</tr>
	</table>
</form>
</div>

<?php include("footer.php"); ?>