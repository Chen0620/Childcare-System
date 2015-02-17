<?php
	//include('error.php');
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

<?php
	$user=$_SESSION['username'];
	//$usertype=$_SESSION['usertype'];
	//if(strcmp($user,'')==0)
	//{
	//	header("Location:login.php");
	//}
//	else
	//{
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
						echo "<td><form method='POST' action='updateMember.php'><input type='submit' value='Updatefff' name='updatemember' ></form></td>";
						echo "<td><form method='POST' action='deleteMember.php'><input type='submit' value='Delete' name='deletemember' ></form></td></tr>";
					}
					
					echo "</table><br />";
				}
			}
		}
		if(strcmp($_POST['listall'],'')!=0||strcmp($_SESSION['listall'],'')!=0)
		{
			$query="SELECT * FROM Member";
			$result=mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
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
				echo "<br /><br /><table><tr><th>Member ID</th><th>Firstname</th><th>Lastname</th><th>Phone</th><th>Birthday</th><th>Address</th><th>Member Date</th><th>Spouse</th><th>Organization</th></tr>";
				$_SESSION['count']=$count;;
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
					//echo "<td><input type='checkbox' value='$id' name='check'></form></td></tr>";
				}
				echo "</table>";
				//echo "<input type='submit' value='Delete Selected' name='deletemember'>";
				echo "<br/><p><b>Delete by ID:</b></p><form action='deleteMember.php' method='GET'><input type='text' name='did'>(* Multiple IDs seperated by <b>\",\"</b>)<br/><input type='submit' value='Delete' name='dids'></form>";
				echo "<a href='#myModal' role='button' class='btn' data-toggle='modal'>Update Member</a>";
				//echo "<br/><p><b>Update by ID:</b></p><form action='updateMember.php' method='GET'><input type='text' name='uid'>(* Only one ID)<br/><input type='submit' value='Update' name='dids'></form>";
				unset($_POST['listall']);
				unset($_SESSION['listall']);
			}
		}
	//}
?>

	<h3>Add member</h3>
	<font>(* are required fields)</font>
	<form method="POST" action="test2.php">
		<label for="mfname"><b>Firstname:</b></label>
		<input id="mfname" name="mfname" type="text"/><font color="red">*</font>
		<br />
		<label for="mlname"><b>Lastname:</b></label>
		<input id="mlname" name="mlname" type="text"/><font color="red">*</font>
		<br />
		<label for="mbday"><b>Birthday(mm/dd/yyyy):</b></label>
		<input id="mbday" name="mbday" type="text"/><font color="red">*</font>
		<br />
		<label for="mphone"><b>Phone:</b></label>
		<input id="mphone" name="mphone" type="text"/>
		<br />
		<label for="maddress"><b>Address:</b></label>
		<input id="maddress" name="maddress" type="text"/>
		<br />				
		<label for="memberdate"><b>Member Date(mm/dd/yyyy):</b></label>
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
	<form method="POST" action="test2.php">
		<label for="searchfname"><b>Search by Firstname:</b></label>
		<input id="searchfname" name="searchfname" type="text"/><br />
		<label for="searchlname"><b>Search by Lastname:</b></label>
		<input id="searchlname" name="searchlname" type="text"/><br />
				
		<input type="submit" value="Search" name="searchmember">
		<input type="submit" value="View Directory" name="listall">
	</form>
	

