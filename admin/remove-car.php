<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();
$uname=$_SESSION['uname'];

$query=mysqli_query($conn,"SELECT * FROM admin");
$num=mysqli_num_rows($query);
if($num>1)
{
if(!mysqli_query($conn,"DELETE FROM admin WHERE uname='$uname'"))
{
	echo "PROBLEM IN REMOVING YOUR ACCOUNT.";
	
}	
else
{
	echo "SUCCESSSFULLY REMOVED YOUR ACCOUNT.";
}
}
else
{
	echo "YOU ARE THE ONLY ADMIN PRESENT INTRODUCE NEW ADMIN THEN REMOVE YOUR ACCOUNT.";
	exit(0);
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
	