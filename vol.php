<?php
	include("header.php");
?>
<style>
textarea{
	height:100px;
	width:300px;
}


tr#result:hover{
	background-color:pink;	
}
td#result,tr#result,th#result{
border:1px black solid;
text-align:center;
}

</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"></script>
<script>
	$(document).ready(function() {
		$('#edate').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>

<?php
	$user=$_SESSION['username'];
	if(strcmp($user,'')==0)
	{
		header("Location:login.php");
	}
	else
	{
		if(strcmp($_POST['createevent'],'')!=0)
		{
			if(strcmp($_POST['ename'],'')==0||strcmp($_POST['enum'],'')==0||strcmp($_POST['eorg'],'')==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']="Please complete all required fields.";
			}
			else
			{
				$ename=$_POST['ename'];
				$edate=$_POST['edate'];
				$enum=$_POST['enum'];
				$edesc=$_POST['edesc'];
				$edesc=mysqli_real_escape_string($link,$edesc);
				$eorg=$_POST['eorg'];
				
				$query="SELECT VolOpprtDate FROM VolunteerOpportunities WHERE VolOpprtDate='$edate'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count!=0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']="Only one event can be held in one day. Please select another date.";
				}
				else
				{
					$query="INSERT INTO VolunteerOpportunities VALUES ('','$edate',$enum,'$edesc','','$ename','$eorg')";
					$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
					echo "Event added successfully!";
				}
			}
		}
		if(strcmp($_POST['deleteevent'],'')!=0)
		{
			for($i=0;$i<$_SESSION['count'];$i++)
			{
				if(!empty($_POST[$i]))
					$dset=$dset.$_POST[$i].",";
			}
			$set = substr("$dset", 0, -1);
			$query="DELETE FROM VolunteerOpportunities WHERE VolOpprtID IN ($set)";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			echo "<b>Successful deletion!</b>";
			$_POST['viewall']=1;
		}
		if(strcmp($_POST['update'],'')!=0)
		{
			$j=0;
			for($i=0;$i<$_SESSION['count'];$i++)
			{
				if(!empty($_POST[$i]))
				{
					$_SESSION['uid']=$_POST[$i];
					$j++;
				}
				if($j>1)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']='Only one event can be updated at one time. Please select again.';
				}
			}
			if(!isset($_SESSION['errorFlag']))
				header("Location:volEdit.php");
		}
		if(strcmp($_POST['updateevent'],'')!=0)
		{
			$id=$_SESSION['uid'];
			unset($_SESSION['uid']);
			
				$query="SELECT * FROM VolunteerOpportunities WHERE VolOpprtID='$id'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
				{
					$i=0;
					foreach($line as $col_value)
					{
						$array[$i]=$col_value;
						$i++;
					}
				}
				$ename=$array[5];
				$edate=$array[1];
				$enum=$array[2];
				$edesc=$array[3];
				$edesc=mysqli_real_escape_string($link,$edesc);
				$eorg=$array[6];
				
				if(strcmp($_POST['ename'],'')!=0)
					$ename=$_POST['ename'];
				$edate2=$_POST['edate'];
				
				$query="SELECT * FROM VolunteerOpportunities WHERE VolOpprtDate='$edate2'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count!=0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']='Only one event can be held in one day. Please select another date.';
				}
				else
				{			
					if(strcmp($edate2,'')==0)
						$edate2=$edate;
					$edate=$edate2;
					if(strcmp($_POST['enum'],'')!=0)
						$enum=$_POST['enum'];
					if(strcmp($_POST['edesc'],'')!=0)
						$edesc=$_POST['edesc'];
					$edesc=mysqli_real_escape_string($link,$edesc);
					if(strcmp($_POST['eorg'],'')!=0)
						$eorg=$_POST['eorg'];
					$query="UPDATE VolunteerOpportunities SET VolOpprtName='$ename',VolOpprtDate='$edate',VolOpprtNumNeed='$enum',VolOpprtDescription='$edesc',OrganizationName='$eorg' WHERE VolOpprtID='$id'";
					$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
					echo "<p><b>Event updated successfully!</b></p>";
					$_POST['viewall']=1;
				}
		}
		if(strcmp($_POST['viewall'],'')!=0)
		{
			$query="SELECT VolOpprtID,VolOpprtName,VolOpprtDate,VolOpprtNumNeed,VolOpprtDescription,OrganizationName FROM VolunteerOpportunities";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$_SESSION['count']=mysqli_num_rows($result);
			if($_SESSION['count']==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']='No results!';
			}
			else
			{
				echo  "<form action='vol.php' method='POST'><table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Number of Volunteer</th><th id='result'>Description</th><th id='result'>Organization</th><th id='result'>Select</th></tr>";
				$j=0;
				while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
				{
					echo "<tr id='result'>";
					$i=0;
					foreach($line as $col_value)
					{
						$array[$i]=$col_value;
						echo "<td id='result'>$col_value</td>";
						$i++;
					}
					$id=$array[0];
					echo "<td><input type='checkbox' value='$id' name='$j'/></td></tr>";
					$j++;
				}
				echo "</table>";
				echo "<br/><input type='submit' value='Delete selected' name='deleteevent'/><input type='submit' value='Update' name='update'/></form><br/>";
			}
		}
	}


	include("error.php");
?>
<br /><br />
<form method="POST" ACTION="vol.php">
	<table>
		<tr><th><b>Create Volunteer Event</b></th><th>(* are required fields)</th></tr>
		<tr>	
			<td><label for="ename"><b>Event Name:</b></label></td>
			<td><input id="ename" name="ename" type="text"/><font color="red">*</font></td>
		</tr>
		<tr>
			<td><label for="edate"><b>Event Date:</b></label></td>
			<td>
				<input type="text" id="edate" name="edate" /><font color="red">*</font>
			</td>
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
			<td><input type="submit" value="Create Event" name="createevent"></td>
			<td><input type="submit" value="View All" name="viewall"></td>
		</tr>
	</table>
</form>


</div>
<?php include("footer.php"); ?>