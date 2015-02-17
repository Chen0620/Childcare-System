<style>
tr#result:hover{
	background-color:pink;	
}
td#result,tr#result,th#result{
border:1px black solid;
text-align:center;
}
</style>


<?php
	include("header.php");
	include('includes.php');
	
	$user=$_SESSION['username'];
	if(strcmp($user,'')==0)
	{
		header("Location:login.php");
	}
	else
	{
		if(strcmp($_POST['createorg'],'')!=0)
		{
			if(strcmp($_POST['oname'],'')==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']="Please complete required field.";
			}
			else
			{
				$oname=$_POST['oname'];
				$orgadd=$_POST['orgadd'];
				
				$query="SELECT OrganizationName FROM Organization WHERE OrganizationName='$oname'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count!=0)
				{
					$_SESSION['errorFlag']=1;
					$_SESSION['error[0]']="Your Organization name has been used. Please use another one.";
				}
				else
				{
					$query="INSERT INTO Organization (OrganizationName, OrganizationAddress) VALUES ('$oname','$orgadd')";
					$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
					echo "Organization added successfully!";
				}
			}
		}
		if(strcmp($_POST['updateorg'],'')!=0)
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
					$_SESSION['error[0]']='Only one organization can be updated at one time. Please select again.';
				}
			}
			if(!isset($_SESSION['errorFlag']))
				header("Location:orgEdit.php");
		}
		if(strcmp($_POST['update'],'')!=0)
		{
			$id=$_SESSION['uid'];
			unset($_SESSION['uid']);
			$query="SELECT * FROM Organization WHERE OrganizationID='$id'";
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
			$oname=$array[1];
			$oadd=$array[2];
			if(strcmp($_POST['ooname'],'')!=0)
				$oname2=$_POST['ooname'];				
			$query="SELECT * FROM Organization WHERE OrganizationName='$oname2'";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$count=mysqli_num_rows($result);
			if($count!=0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']='Your Organization name has been used. Please use another one.';
			}
			else
			{			
				if(strcmp($oname2,'')!=0)
				{
					if(strcmp($oname,$oname2)!=0)
						$oname=$oname2;
				}
				if(strcmp($_POST['ooadd'],'')!=0)
					$oadd=$_POST['ooadd'];
				$query="UPDATE Organization SET OrganizationName='$oname',OrganizationAddress='$oadd' WHERE OrganizationID='$id'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				echo "<p><b>Organization updated successfully!</b></p>";
				$_POST['viewallorg']=1;
			}
		}		
		if(strcmp($_POST['deleteorg'],'')!=0)
		{
			for($i=0;$i<$_SESSION['count'];$i++)
			{
				if(!empty($_POST[$i]))
					$dset=$dset.$_POST[$i].",";
			}
			$set = substr("$dset", 0, -1);
			$query="DELETE FROM Organization WHERE OrganizationID IN ($set)";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			echo "<b>Successful deletion!</b>";
			$_POST['viewallorg']=1;
		}
		
		if(strcmp($_POST['viewallorg'],'')!=0)
		{
			$query="SELECT OrganizationID,OrganizationName,OrganizationAddress FROM Organization";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$_SESSION['count']=mysqli_num_rows($result);
			if($_SESSION['count']==0)
			{
				$_SESSION['errorFlag']=1;
				$_SESSION['error[0]']='No results!';
			}
			else
			{
				echo  "<form action='org.php' method='POST'><table id='result'><tr id='result'><th id='result'>Organization Id</th><th id='result'>Organization Name</th><th>Organization Address</th><th id='result'>Event Assigned</th><th id='result'>Select</th></tr>";
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
					$oname=$array[1];
					$query2="SELECT VolOpprtName FROM VolunteerOpportunities WHERE OrganizationName='$oname'";
					$result2 = mysqli_query($link, $query2) or die("Query failed : " . mysqli_error());
					while ($line2=mysqli_fetch_array($result2, MYSQL_ASSOC))
					{
						foreach($line2 as $cv)
						{
							$vol=$cv.",".$vol;
						}
					}
					$vol=substr($vol,0,strlen($vol)-1);
					echo "<td id='result'>$vol</td><td><input type='checkbox' value='$id' name='$j'/></td></tr>";
					$j++;
					$vol="";
				}
				echo "</table>";
				echo "<br/><input type='submit' value='Delete selected' name='deleteorg'/><input type='submit' value='Update' name='updateorg'/></form><br/>";
			}
		}
	}
	include("error.php");
?>

<form method="POST" ACTION="org.php">
	<table>
		<tr><th><b>Create/ Delelte/ Update Organization</b></th><th>(* are required fields)</th></tr>
		<tr>	
			<td><label for="oname"><b>Organization Name:</b></label></td>
			<td><input id="oname" name="oname" type="text"/><font color="red">*</font></td>
		</tr>
		<tr>
			<td><label for="orgadd"><b>Organization Address:</b></label></td>
			<td><input id="orgadd" name="orgadd" type="text"/>
		</tr>
		<tr>
			<td><input type="submit" value="Create Organization" name="createorg"></td>
			<td><input type="submit" value="View All" name="viewallorg"></td>
		</tr>
	</table>
</form>
<?php include("footer.php"); ?>