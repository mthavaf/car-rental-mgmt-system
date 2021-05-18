<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$opas=$_POST['opas'];
$uname=$_SESSION["uname"];
$new=$_POST['npas'];
$query=mysqli_query($conn,"SELECT * FROM supplier WHERE uname='$uname' and password='$opas'");
$count=mysqli_num_rows($query);
if($count==0)
{
	echo "enter correct old password ";
	exit(0);
}
if(!mysqli_query($conn,"UPDATE supplier SET password='$new' where uname='$uname'" ))
{
	echo "problem while ressetting your password try again later.";
}
else
{
	echo "successfully changed.";
	
}
}
mysqli_close($conn);
?>