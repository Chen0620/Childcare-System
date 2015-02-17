<?php

	include("includes.php");
	
	$_SESSION['error'] = array();
	$_SESSION['errorFlag']=false;

	$username=$_POST['username'];
	$password=$_POST['password'];
	$hash=makehash($password,$username);
	$hash=mysqli_real_escape_string($link,$hash);
	
	function makeHash($password, $username) 
	{
		return crypt($password, $username);
	}

	
	if($username=='') 
	{
		$_SESSION["error[0]"] = 'Please insert your Username.';
		$_SESSION['errorFlag']= true;
	}
	if($password=='') 
	{
		$_SESSION["error[1]"] = 'Please insert your Password.';
		$_SESSION['errorFlag']= true;
	}
	if($_SESSION['errorFlag']==1)
		header('Location:index.php');
	
	
	$username=mysqli_real_escape_string($link,$username);
	$query="SELECT user_type,hash FROM users LEFT JOIN authentication ON users.authentication_id=authentication.authentication_id where users.username='$username'";
	$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
	$i=0;
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC))
	{
		foreach ($line as $col_value)
		{
			$array[$i]=$col_value;
			$i++;
		}
	}
	$count=mysqli_num_rows($result);
	
	if($count==0)
	{
		$_SESSION['errorFlag']=true;
		$_SESSION["error[2]"]='There is no such username.';
	}
	else
	{
		$usertype=$array[0];
		$hashed=$array[1];
		
		if(strcmp($hash,$hashed)!=0)
		{
			$_SESSION['errorFlag']=true;
			$_SESSION["error[3]"]='Username and password do not match!';
		}
		else
		{
			$_SESSION['username']=$username;
			$_SESSION['user_type_id'] = $usertype;
			
			$query="SELECT user_type FROM user_type WHERE user_type_id=$usertype";
			$result = mysqli_query($link, $query) or die("Query failed : " . mysqli_error());
			$i=0;
			while ($line = mysqli_fetch_array($result, MYSQL_ASSOC))
			{
				foreach ($line as $col_value)
				{
					$usertype=$col_value;
				}
			}
			$_SESSION['usertype']=$usertype;
			echo "$usertype";
			$_SESSION['errorFlag']=false;
			header('Location:calendar.php');
		}
	}
	if($_SESSION['errorFlag']==1)
		header('Location:test4.php');

?>