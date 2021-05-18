<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();
$uname=$_SESSION['uname'];
if(mysqli_query($conn,"DELETE FROM supplier WHERE uname='$uname'"))
{
	if(mysqli_query($conn,"DELETE FROM car_list WHERE uname='$uname'"))
	{
		echo "YOUR ACOOUNT HAS REMOVED.";
	}
	else
	{
		echo "success inner";
	}

}
else
{ echo "PROBLEM IN REMOVING YOUR ACCOUNT.";
}
session_unset();
session_destroy();
	mysqli_close($conn);
	?>
	<html>
	<body>
	<p>GO BACK TO HOME PRESS HOME BUTTON</p>
	<a href="/dbPro/home.html"> HOME </a>
	</body>
	</html>
	