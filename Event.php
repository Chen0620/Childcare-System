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
			if(strcmp($_POST['ename'],'')==0||strcmp($_POST['eroom'],'')==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']="Please complete all required fields.";
			}
			else
			{
				$ename=$_POST['ename'];
				$edate=$_POST['edate'];
				$etime=$_POST['esh'].':'.$_POST['esm'].':00';
				$eroom=$_POST['eroom'];
				if(strcmp($_POST['ehour'],'')==0)
					$_POST['ehour']=0;
				if(strcmp($_POST['emin'],'')==0)
					$_POST['emin']=0;
				$eduration=$_POST['ehour'].' Hours '.$_POST['emin'].' Minutes';
				$edesc=$_POST['edesc'];
				$edesc=mysqli_real_escape_string($link,$edesc);
				
				$query="SELECT EventDate FROM EventOfExploration WHERE EventDate='$edate'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count!=0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']="Only one event can be held in one day. Please select another date.";
				}
				else
				{
					$query="INSERT INTO EventOfExploration VALUES ('','$ename','$edate','$eroom','$edesc','$eduration',2,'$etime')";
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
			$query="DELETE FROM EventOfExploration WHERE EventID IN ($set)";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			echo "Successful deletion!";
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
				header("Location:eventEdit.php");
		}
		if(strcmp($_POST['updateevent'],'')!=0)
		{
			$id=$_SESSION['uid'];
			unset($_SESSION['uid']);
			$query="SELECT * FROM EventOfExploration WHERE EventID='$id'";
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
			$ename=$array[1];
			$edate=$array[2];
			$eroom=$array[3];
			$edesc=$array[4];
			$edesc=mysqli_real_escape_string($link,$edesc);
			$eduration=$array[5];
			$etime=$array[7];
			
			if(strcmp($_POST['ename'],'')!=0)
				$ename=$_POST['ename'];
			$edate2=$_POST['edate'];
			
			$query="SELECT * FROM EventOfExploration WHERE EventDate='$edate2'";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$count=mysqli_num_rows($result);
			if($count!=0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']='Only one event can be held in one day. Please select another date.';
			}
			else
			{			
				if(strcmp($edate,$edate2)!=0&&strcmp($edate2,'')!=0)
					$edate=$edate2;
				if(strcmp($_POST['eroom'],'')!=0)
					$eroom=$_POST['eroom'];
				if(strcmp($_POST['ehour'],'')!=0&&strcmp($_POST['emin'],'')!=0)
				{
					$ehour=$_POST['ehour'];
					$emin=$_POST['emin'];
					$eduration=$ehour.' Hours '.$emin.' Minutes';
				}
				if(strcmp($_POST['edesc'],'')!=0)
					$edesc=$_POST['edesc'];
				$edesc=mysqli_real_escape_string($link,$edesc);
				if(strcmp($_POST['esh'],'')!=0&&strcmp($_POST['esm'],'')!=0)
					$etime=$_POST['esh'].':'.$_POST['esm'].':00';
				
				$query="UPDATE EventOfExploration SET EventName='$ename',EventDate='$edate',EventRoom='$eroom',EventDescription='$edesc',EventDuration='$eduration', EventTime='$etime' WHERE EventID='$id'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				echo "<p><b>Event updated successfully!</b></p>";
				$_POST['viewall']=1;
			}
		}
		if(strcmp($_POST['viewall'],'')!=0)
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
				echo  "<form action='Event.php' method='POST'><table id='result'><tr id='result'><th id='result'>Event Id</th><th id='result'>Event Name</th><th>Date</th><th id='result'>Start Time</th><th id='result'>Room</th><th id='result'>Description</th><th id='result'>Duration</th><th id='result'>Select</th></tr>";
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
<form method="POST" ACTION="Event.php">
	<table>
		<tr><th><b>Create Main Building Event (Event of Exploration)</b></th><th>(* are required fields)</th></tr>
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
			<td><label for="est"><b>Event Start Time:</b></label></td>
			<td>
				<input id="esh" name="esh" type="text"/> <b>:</b> <input id="esm" name="esm" type="text"/>
				<font color="red">*</font>
			</td>
		</tr>
		<tr>
			<td><label for="eroom"><b>Event Room:</b></label></td>
			<td><input id="eroom" name="eroom" type="text"/><font color="red">*</font></td>
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
			<td><input type="submit" value="Create Event" name="createevent"></td>
			<td><input type="submit" value="View All" name="viewall"></td>
		</tr>
	</table>
</form>


</div>
<?php include("footer.php"); ?>