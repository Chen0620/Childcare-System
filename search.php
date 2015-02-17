<style>
	tr#result:hover
	{
		background-color:pink;	
	}
	td#result,tr#result,th#result{
	border:1px black solid;
	text-align:center;
	}
</style>
<?php
	include("includes.php");
	include("header.php");
?>
<?php
	if(strcmp($_POST['searchn'],'')!=0)
	{
		if(strcmp($_POST['ename'],'')==0||strcmp($_POST['type'],'')==0)
		{
			$_SESSION['errorFlag']=1;
			$_SESSION['error[0]']="Please complete required field.";
		}
		else
		{
			$sname=$_POST['ename'];
			
			if(strcmp($_POST['type'],'Event')==0)
			{
				$query="SELECT EventID,EventName,EventDate,EventTime,EventRoom,EventDescription,EventDuration FROM EventOfExploration WHERE EventName LIKE '%$sname%'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count==0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']="No results. Please search another name.";
				}
				else
				{
					echo "<b>The events contains \"$sname\" shown below:</b>";
					echo  "<br /><table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Start Time</th><th id='result'>Room</th><th id='result'>Description</th><th id='result'>Duration</th></tr>";
					while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
					{
						echo "<tr id='result'>";
						foreach($line as $col_value)
							echo "<td id='result'>$col_value</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			}
			else if(strcmp($_POST['type'],'vol')==0)
			{
				$query="SELECT VolOpprtID,VolOpprtName,VolOpprtDate,VolOpprtNumNeed,VolOpprtDescription,OrganizationName FROM VolunteerOpportunities WHERE VolOpprtName LIKE '%$sname%'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$_SESSION['count']=mysqli_num_rows($result);
				if($_SESSION['count']==0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']='No results!';
				}
				else
				{
					echo "<b>The volunteer opportunities contains \"$sname\" shown below:</b>";
					echo  "<table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Number of Volunteer</th><th id='result'>Description</th><th id='result'>Organization</th></tr>";
					while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
					{
						echo "<tr id='result'>";
						foreach($line as $col_value)
							echo "<td id='result'>$col_value</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			}
		}
	}
	else if(strcmp($_POST['searcht'],'')!=0)
	{
		if(strcmp($_POST['edate'],'')==0||strcmp($_POST['type'],'')==0)
		{
			$_SESSION['errorFlag']=1;
			$_SESSION['error[0]']="Please complete required field.";
		}
		else
		{
			$sdate=$_POST['edate'];
			
			if(strcmp($_POST['type'],'Event')==0)
			{
				$query="SELECT EventID,EventName,EventDate,EventTime,EventRoom,EventDescription,EventDuration FROM EventOfExploration WHERE EventDate='$sdate'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count==0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']="No results. Please search another name.";
				}
				else
				{
					echo "<b>The events on \"$sdate\" shown below:</b>";
					echo  "<br /><table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Start Time</th><th id='result'>Room</th><th id='result'>Description</th><th id='result'>Duration</th></tr>";
					while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
					{
						echo "<tr id='result'>";
						foreach($line as $col_value)
							echo "<td id='result'>$col_value</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			}
			else if(strcmp($_POST['type'],'vol')==0)
			{
				$query="SELECT VolOpprtID,VolOpprtName,VolOpprtDate,VolOpprtNumNeed,VolOpprtDescription,OrganizationName FROM VolunteerOpportunities WHERE VolOpprtDate='$sdate'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$_SESSION['count']=mysqli_num_rows($result);
				if($_SESSION['count']==0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']='No results!';
				}
				else
				{
					echo "<b>The volunteer opportunities on \"$sdate\" shown below:</b>";
					echo  "<table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Number of Volunteer</th><th id='result'>Description</th><th id='result'>Organization</th></tr>";
					while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
					{
						echo "<tr id='result'>";
						foreach($line as $col_value)
							echo "<td id='result'>$col_value</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			}
		}
	}
	else if (strcmp($_POST['searche'],'')!=0)
		{
			$query="SELECT EventID,EventName,EventDate,EventTime,EventRoom,EventDescription,EventDuration FROM EventOfExploration";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$_SESSION['count']=mysqli_num_rows($result);
			if($_SESSION['count']==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']='No results!';
			}
			else
			{
				echo "<b>Listing all events of Exploration:</b><br />";
				echo  "<table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Start Time</th><th id='result'>Room</th><th id='result'>Description</th><th id='result'>Duration</th></tr>";
				while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
				{
					echo "<tr id='result'>";
					foreach($line as $col_value)
						echo "<td id='result'>$col_value</td>";
				}
				echo "</table>";
			}
		}
		else if(strcmp($_POST['searchv'],'')!=0)
		{
			echo "<b>Listing all volunteer opportunities:</b><br />";
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
				echo "<table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Number of Volunteer</th><th id='result'>Description</th><th id='result'>Organization</th></tr>";
				while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
				{
					echo "<tr id='result'>";
					foreach($line as $col_value)
						echo "<td id='result'>$col_value</td>";
				}
				echo "</table>";
			}
		}
	
	include("error.php");
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"></script>
<script>
	$(document).ready(function() {
		$('#edate').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>

<br />
<form method="POST" action="search.php">
	<table>
		<tr><th><b>Search Events by name containing words: </b></th></tr>
		<tr>	
			<td><label for="ename"><b>Event Name:</b></label></td>
			<td><input id="ename" name="ename" type="text"/></td>
		</tr>
		<tr>
			<td><label><b>Event Type:</b></label></td>
			<td><input type="radio" name="type" value="Event">Event of Exploration</td>
			<td><input type="radio" name="type" value="vol">Volunteer Opportunities</td>
		</tr>
		<tr><td><input id="searchn" type="submit" name="searchn" value="Search"></td></tr>
	</table>
</form>

<form method="POST" action="search.php">
	<table>
		<tr><th><b>Search Events by date: </b></th></tr>
		<tr>	
			<td><label for="ename"><b>Event date:</b></label></td>
			<td><input type="text" id="edate" name="edate"/></td>
		</tr>
		<tr>
			<td><label><b>Event Type:</b></label></td>
			<td><input type="radio" name="type" value="Event">Event of Exploration</td>
			<td><input type="radio" name="type" value="vol">Volunteer Opportunities</td>
		</tr>
		<tr><td><input id="searchn" type="submit" name="searcht" value="Search"></td></tr>
	</table>
</form>

<form method="POST" action="search.php">
	<table>
		<tr><th><b>Search Events by type: </b></th></tr>
		<tr></tr>
		<tr>
			<td><input id="searchn" type="submit" name="searche" value="Show All Event of Exploration"></td>
			<td><input id="searchn" type="submit" name="searchv" value="Show All Volunteer Oppportunities"></td>
		</tr>
	</table>
</form>

</div>
<?php include("footer.php"); ?>