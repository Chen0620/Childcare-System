<?php
	include('header.php');
	include('error.php');
?>
<style>
td,th{
border:1px black solid;
text-align:center;
}
tr:hover{
background-color:pink;
}

</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"></script>
<script>
	$(document).ready(function() {
		$('#memberdate').datepicker({dateFormat: 'yy-mm-dd'});
		$('#mbday').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>

<?php
	$user=$_SESSION['username'];
	//$usertype=$_SESSION['usertype'];
	if(strcmp($user,'')==0)
	{
		header("Location:login.php");
	}
	else
	{
		if(strcmp($_SESSION['updatemember'],'')!=0)
		{
			echo "Update Successfully!";
			unset($_SESSION['updatemember']);
			$_POST['listall']='Show All Members';
		}
		if(strcmp($_SESSION['deletemember'],'')!=0)
		{
			echo "Delete Successfully!";
			unset($_SESSION['deletemember']);
			$_POST['listall']='Show All Members';
		}
		if(strcmp($_POST['addmember'],'')!=0)
		{
			$mfname=$_POST['mfname'];
			$mlname=$_POST['mlname'];
			$mphone=$_POST['mphone'];
			$mbday=$_POST['mbday'];
			$maddress=$_POST['maddress'];
			$memberdate=$_POST['memberdate'];
			$mspousename=$_POST['mspousename'];
			$morg=$_POST['morg'];
			
			if(strcmp($_POST['mfname'],'')==0||strcmp($_POST['mlname'],'')==0||strcmp($_POST['mbday'],'')==0)
			{
				echo "<br /><br />";
				echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>";
				echo "<strong>Please complete all the required fields.</strong><br />\n";
				echo "</div>";
			}
			else
			{
				$mfname=mysqli_real_escape_string($link,$mfname);
				$mlname=mysqli_real_escape_string($link,$mlname);
				$query="SELECT MemberFname, MemberLname FROM Member WHERE MemberFname='$mfname' AND MemberLname='$mlname'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count!=0)
				{
					echo "<br /><br />";
					echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>";
					echo "<strong>The member name exists!</strong><br />\n";
					echo "</div>";
				}
				else
				{
					$query="INSERT INTO Member VALUES ('','$mfname','$mlname','$mphone','$mbday','$maddress','$memberdate','$mspousename','$morg')";
					$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
					echo "Member added successfully!";
				}
			}
		}
		if(strcmp($_POST['searchmember'],'')!=0)
		{
			$sfname=$_POST['searchfname'];
			$slname=$_POST['searchlname'];
			
			if(strcmp($_POST['searchfname'],'')==0&&strcmp($_POST['searchlname'],'')==0)
			{
				echo "<br /><br />";
				echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>";
				echo "<strong>Please search member by at least one field.</strong><br />\n";
				echo "</div>";
			}
			else
			{
				$sfname=mysqli_real_escape_string($link,$sfname);
				$slname=mysqli_real_escape_string($link,$slname);
				$query="SELECT * FROM Member WHERE MemberFname='$sfname' OR MemberLname='$slname'";
				$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
				$count=mysqli_num_rows($result);
				if($count==0)
				{
					echo "<br /><br />";
					echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>";
					echo "<strong>No result!</strong><br />\n";
					echo "</div>";
				}
				else
				{
					echo "<br /><br /><table><tr><th>Member ID</th><th>Firstname</th><th>Lastname</th><th>Phone</th><th>Birthday</th><th>Address</th><th>Member Date</th><th>Spouse</th><th>Organization</th><th>Update</th><th>Delete</th></tr>";
					while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
					{
						echo "<tr>";
						$i=0;
						foreach($line as $col_value)
						{
							$array[$i]=$col_value;
							echo "<td>$col_value</td>";
							$i++;
						}
						$_SESSION['id']=$array[0];
						echo "<td><form method='POST' action='updateMember.php'><input type='submit' value='Update' name='updatemember' ></form></td>";
						echo "<td><form method='POST' action='deleteMember.php'><input type='submit' value='Delete' name='deleteone' ></form></td></tr>";
					}
					
					echo "</table>";
				}
			}
		}
		if(strcmp($_POST['deletem'],'')!=0)
		{
			for($i=0;$i<$_SESSION['count'];$i++)
			{
				if(!empty($_POST[$i]))
					$dset=$dset.$_POST[$i].",";
			}
			$set = substr("$dset", 0, -1);
			$query="DELETE FROM Member WHERE MemberID IN ($set)";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			echo "Successfully deleted!";
			$_POST['listall']=1;
					
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
					$_SESSION['error[0]']='Only one member can be updated at one time. Please select again.';
				}
				
			}
			if(!isset($_SESSION['errorFlag']))
				header("Location:updateMember.php");
		}
		if(strcmp($_POST['listall'],'')!=0||strcmp($_SESSION['listall'],'')!=0)
		{
			$query="SELECT * FROM Member";
			$result=mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$count=mysqli_num_rows($result);
			$SESSION['count']=$count;
			if($count==0)
			{
				echo "<br /><br />";
				echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>";
				echo "<strong>No result!</strong><br />\n";
				echo "</div>";
			}
			else
			{
				echo "<br /><br /><form method='POST' action='manageMember.php'><table><tr><th>Member ID</th><th>Firstname</th><th>Lastname</th><th>Phone</th><th>Birthday</th><th>Address</th><th>Member Date</th><th>Spouse</th><th>Organization</th><th>Select</th></tr>";
				$_SESSION['count']=$count;
				$j=0;
				while ($line=mysqli_fetch_array($result, MYSQL_ASSOC))
				{
					echo "<tr>";
					$i=0;
					foreach($line as $col_value)
					{
						$array[$i]=$col_value;
						echo "<td>$col_value</td>";
						$i++;
					}
					$id=$array[0];
					echo "<td><input type='checkbox' value='$id' name='$j'></form></td></tr>";
					$j++;
				}
				echo "</table>";
				//echo "<input type='submit' value='Delete Selected' name='deletemember'>";
				echo "<br/><input type='submit' value='Delete selected' name='deletem'/><input type='submit' value='Update' name='update'/></form><br/>";
				//echo "<br/><p><b>Delete by ID:</b></p><form action='deleteMember.php' method='GET'><input type='text' name='did'>(* Multiple IDs seperated by <b>\",\"</b>)<br/><input type='submit' value='Delete' name='dids'></form>";
				//echo "<br/><p><b>Update by ID:</b></p><form action='updateMember.php' method='GET'><input type='text' name='uid'>(* Only one ID)<br/><input type='submit' value='Update' name='dids'></form>";
				unset($_POST['listall']);
				unset($_SESSION['listall']);
			}
		}
		include ("error.php");
	}
?>
<table>
	
	<h3>Add member</h3>
	<font>(* are required fields)</font>
	<form method="POST" action="manageMember.php">
		<label for="mfname"><b>Firstname:</b></label>
		<input id="mfname" name="mfname" type="text"/><font color="red">*</font>
		<br />
		<label for="mlname"><b>Lastname:</b></label>
		<input id="mlname" name="mlname" type="text"/><font color="red">*</font>
		<br />
		<label for="mbday"><b>Birthday:</b></label>
		<input id="mbday" name="mbday" type="text"/><font color="red">*</font>
		<br />
		<label for="mphone"><b>Phone:</b></label>
		<input id="mphone" name="mphone" type="text"/>
		<br />
		<label for="maddress"><b>Address:</b></label>
		<input id="maddress" name="maddress" type="text"/>
		<br />				
		<label for="memberdate"><b>Member Date:</b></label>
		<input id="memberdate" name="memberdate" type="text"/>
		<br />
		<label for="mspousename"><b>Spouse Name:</b></label>
		<input id="mspousename" name="mspousename" type="text"/>
		<br />
		<label for="morg"><b>Organization:</b></label>
		<input id="morg" name="morg" type="text"/>
		<br />
		<input type="submit" value="Submit" name="addmember">
	</form>
	<br /><br />
	<h3>Search/ Update/ Delete member</h3>
	<font>(at least one field is required)</font>
	<form method="POST" action="manageMember.php">
		<label for="searchfname"><b>Search by Firstname:</b></label>
		<input id="searchfname" name="searchfname" type="text"/><br />
		<label for="searchlname"><b>Search by Lastname:</b></label>
		<input id="searchlname" name="searchlname" type="text"/><br />
				
		<input type="submit" value="Search" name="searchmember">
		<input type="submit" value="View Directory" name="listall">
	</form>
	
</div>

<?php include("footer.php"); ?>