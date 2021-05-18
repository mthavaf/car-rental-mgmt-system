<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_POST['uname'];
$count=mysqli_query($conn,"SELECT * FROM organization where uname='$uname'");
$count=mysqli_num_rows($count);
if($count==0)
{
	echo "ENTERED USER NAME IS NOT PRESENT.";
	exit(0);
}
$id=mysqli_query($conn,"SELECT car_id FROM organization where uname='$uname'");
$num=mysqli_query($conn,"SELECT * FROM transaction where car_id='$id'");
if($num!=0)
{
	echo "CUSTOMER RENTED ORGANIZATION CAR REMOVE AFTER HE RETURNED.";
	exit(0);
}
if(!mysqli_query($conn,"DELETE FROM organization where uname='$uname'"))
{
echo "PROBLEM IN REMOVING ORGANIZATION DATA.";
}
else
	echo "SUCCESSFULLY RMOVED PRESS BACK TO MAINTAIN.";
}
mysqli_close($conn);
?>