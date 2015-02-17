<?php
	session_start();
	if($_SESSION['errorFlag']==1)
	{
		for($i=0;$i<=6;$i++)
		{
			$err[$i]=$_SESSION["error[$i]"];
			unset($_SESSION["error[$i]"]);
		}
		foreach($err as $msg)
		{
			if($msg!='') {
?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
<?php
				echo "<strong>$msg</strong><br />\n"; 
?>
</div>
<?php
			}

		}
		echo "</p>\n";
	}
	
	unset($_SESSION['errorFlag']);
?>
