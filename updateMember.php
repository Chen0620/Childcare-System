<?php
	include('includes.php');
	
	$mid=$_SESSION['uid'];
	unset($_SESSION['uid']);
	if(strcmp($_POST['updatemember'],'')!=0)
	{
		$mid=$_SESSION['id'];
		unset($_SESSION['id']);
	}
	if(isset($mid))
	{
		$_SESSION['mid']=$mid;
		$query="SELECT * FROM Member WHERE MemberID='$mid'";
		$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
		$count=mysqli_num_rows($result);
		if($count==0)
		{
			$_SESSION['errorFlag']=1;
			$_SESSION['error[0]']='All IDs do not exist.';
			$_SESSION['listall']=1;
			unset($_SESSION['result']);
			header("Location:manageMember.php");
		}
	}
	
	if(strcmp($_POST['mupdate'],'')!=0)
	{
		$mid=$_SESSION['mid'];
		unset($_SESSION['mid']);		
		$query="SELECT * FROM Member WHERE MemberID='$mid'";
		$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
		$i=0;
		while($line=mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			foreach($line as $col_value)
			{
				$array[$i]=$col_value;
				$i++;
			}
		}
		$fname=$array[1];
		$lname=$array[2];
		$bday=$array[4];
		$phone=$array[3];
		$add=$array[5];
		$mdate=$array[6];
		$sname=$array[7];
		$org=$array[8];
		
		if(strcmp($_POST['mfname'],'')!=0)
			$fname=$_POST['mfname'];
		if(strcmp($_POST['mlname'],'')!=0)
			$lname=$_POST['mlname'];
		if(strcmp($_POST['mphone'],'')!=0)
			$phone=$_POST['mphone'];
		if(strcmp($_POST['mbday'],'')!=0)
			$bday=$_POST['mbday'];
		if(strcmp($_POST['maddress'],'')!=0)
			$add=$_POST['maddress'];
		if(strcmp($_POST['memberdate'],'')!=0)
			$mdate=$_POST['memberdate'];
		if(strcmp($_POST['mspousename'],'')!=0)
			$sname=$_POST['mspousename'];
		if(strcmp($_POST['morg'],'')!=0)
			$org=$_POST['morg'];

		$query="UPDATE Member SET MemberFname='$fname', MemberLname='$lname',MemberPhone='$phone',MemberBday='$bday', MemberAddress='$add',MemberDate='$mdate',Memberspouse='$sname',OrganizationName='$org' WHERE MemberID='$mid'";
		$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
		echo "$mid =lanme";
		$_SESSION['updatemember']=1;
		$_SESSION['listall']=1;
		header("Location:manageMember.php");
	}
	include('header.php');
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"></script>
<script>
	$(document).ready(function() {
		$('#memberdate').datepicker({dateFormat: 'yy-mm-dd'});
		$('#mbday').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>

<h3>Update member</h3>
	<form method="POST" action="updateMember.php">
		<p>(Fill in the fields you want to update)</p>
		<label for="mfname"><b>New Firstname:</b></label>
		<input id="mfname" name="mfname" type="text"/>
		<br />
		<label for="mlname"><b>New Lastname:</b></label>
		<input id="mlname" name="mlname" type="text"/>
		<br />
		<label for="mbday"><b>New Birthday:</b></label>
		<input id="mbday" name="mbday" type="text"/>
		<br />
		<label for="mphone"><b>New Phone:</b></label>
		<input id="mphone" name="mphone" type="text"/>
		<br />
		<label for="maddress"><b>Address:</b></label>
		<input id="maddress" name="maddress" type="text"/>
		<br />				
		<label for="memberdate"><b>New Member Date:</b></label>
		<input id="memberdate" name="memberdate" type="text"/>
		<br />
		<label for="mspousename"><b>New Spouse Name:</b></label>
		<input id="mspousename" name="mspousename" type="text"/>
		<br />
		<label for="morg"><b>New Organization:</b></label>
		<input id="morg" name="morg" type="text"/>
		<br />
		<input type="submit" value="Submit" name="mupdate">
	</form>
	<br />
</div>
<?php include("footer.php"); ?>