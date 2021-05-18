<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();
$uname=$_SESSION['uname'];
if(mysqli_query($conn,"DELETE  FROM organizaion WHERE uname='$uname'"))
{
	if(mysqli_query($conn,"DELETE  FROM car_list WHERE uname='$uname'"))
	{
		echo "YOUR ACOOUNT HAS REMOVED.";
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
	<head>
	 <link rel="stylesheet" href="organization.css">
	 </head>
	<body>
	<p>GO BACK TO HOME PRESS HOME BUTTON</p>
	<a href="/dbPro/home.html"> HOME </a>
	</body>
	</html>
	