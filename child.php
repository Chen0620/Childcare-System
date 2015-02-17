<style>
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
	include("header.php");
	$user=$_SESSION['username'];
	if(strcmp($user,'')==0)
	{
		header("Location:login.php");
	}
	else
	{
		if(strcmp($_POST['create'],'')!=0)
		{
			if(strcmp($_POST['ename'],'')==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']="Please complete all required fields.";
			}
			else
			{
				$ename=$_POST['ename'];
				$edate=$_POST['edate'];
				$emem=$_POST['emem'];
				
				$query="SELECT ChildName FROM ChildofMember WHERE ChildName='$ename'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count!=0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']="Name has been used. Please enter another name.";
				}
				else
				{
					$query="INSERT INTO ChildofMember VALUES ('','$ename','$edate','$emem')";
					$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
					echo "Child added successfully!";
				}
			}
		}
		if(strcmp($_POST['delete'],'')!=0)
		{
			for($i=0;$i<$_SESSION['count'];$i++)
			{
				if(!empty($_POST[$i]))
					$dset=$dset.$_POST[$i].",";
			}
			$set = substr("$dset", 0, -1);
			$query="DELETE FROM ChildofMember WHERE ChildID IN ($set)";
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
					$_SESSION['error[0]']='Only one child can be updated at one time. Please select again.';
				}
			}
			if(!isset($_SESSION['errorFlag']))
				header("Location:childEdit.php");
		}
		if(strcmp($_POST['updatechild'],'')!=0)
		{
			$id=$_SESSION['uid'];
			unset($_SESSION['uid']);
			$query="SELECT * FROM ChildofMember WHERE ChildID='$id'";
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
			$emem=$array[3];

			if(strcmp($_POST['ename'],'')!=0)
			{
				$ename2=$_POST['ename'];
				$ename=$_POST['ename'];
			}
			if(strcmp($_POST['edate'],'')!=0)
				$edate=$_POST['edate'];
			
			$query="SELECT * FROM ChildofMember WHERE ChildName='$ename2'";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$count=mysqli_num_rows($result);
			if($count!=0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']='Name has been used. Please enter another name.';
			}
			else
			{			
				if(strcmp($_POST['emem'],'')!=0)
					$emem=$_POST['emem'];	
				$query="UPDATE ChildofMember SET ChildName='$ename',ChildBDay='$edate',MemberName='$emem' WHERE ChildID='$id'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				echo "<p><b>Record updated successfully!</b></p>";
				$_POST['viewall']=1;
			}
		}
		if(strcmp($_POST['viewall'],'')!=0)
		{
			$query="SELECT * FROM ChildofMember";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$_SESSION['count']=mysqli_num_rows($result);
			if($_SESSION['count']==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']='No results!';
			}
			else
			{
				echo  "<form action='child.php' method='POST'><table id='result'><tr id='result'><th id='result'>Child Id</th><th id='result'>Child Name</th><th>Child Birthday</th><th id='result'>Parent</th><th id='result'>Select</th></tr>";
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
				echo "<br/><input type='submit' value='Delete selected' name='delete'/><input type='submit' value='Update' name='update'/></form><br/>";
			}
		}
	}


	include("error.php");
?>

<form method="POST" ACTION="child.php">
	<table>
		<tr><th><b>Create Child of Member Record</b></th><th>(* are required fields)</th></tr>
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
			<td><input type="submit" value="Create Record" name="create"></td>
			<td><input type="submit" value="View All" name="viewall"></td>
		</tr>
	</table>
</form>
<?php include("footer.php"); ?>