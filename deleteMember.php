<?php
	include('includes.php');
	
	if(strcmp($_POST['deleteone'],'')!=0)
	{
		$id=$_SESSION['id'];
		$query="DELETE FROM Member WHERE MemberID=$id";
		$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
		header("Location:manageMember.php");
	}
	
?>