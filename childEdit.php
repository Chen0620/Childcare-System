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

<form method="POST" ACTION="child.php">
	<table>
		<tr><th><b>Update Child of Member Record</b></th><th>(Only fill in which need to be updated.)</th></tr>
		<tr>	
			<td><label for="ename"><b>Child Name:</b></label></td>
			<td><input id="ename" name="ename" type="text"/><font color="red">*</font></td>
		</tr>
		<tr>
			<td><label for="edate"><b>Birthday:</b></label></td>
			<td>
				<input type="text" id="edate" name="edate" /><font color="red">*</font>
			</td>
		</tr>
		<tr>
			<td><label for="emem"><b>Parent:</b></label></td>
			<td><?php
				$query="SELECT MemberFname FROM Member";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				echo "<select name='emem'><option value=''></option>";
				while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
				{
					foreach($line as $col_value)
						echo "<option value='$col_value'>$col_value</option>";
				}
			echo "</select>";
			?>
		</tr>
		<tr>
			<td><input type="submit" value="Update" name="updatechild"></td>
		</tr>
	</table>
</form>
<?php include("footer.php"); ?>