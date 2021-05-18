<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_SESSION['uname'];
$cid=$_POST['carid'];
$id=mysqli_query($conn,"SELECT * FROM car_list WHERE uanme='$uname' and car_id='$cid' "); // check with count(*) 
$id=mysqli_fetch_assoc($id);
$id=$id['car_id'];
if($id==1)
{ 
if(mysqli_query($conn,"DELETE * FROM car_list WHERE uanme='$uname' and car_id='$cid' "))
	echo "Successfully removed Press back to continue".;
	else
	echo "Problem in removing your car try again later.";
}
else
{
echo "CAR ID entered is incorret.";
}
}
mysqli_close($conn);
?>