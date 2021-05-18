<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_POST['uname'];
$pas=$_POST['password'];
if(!mysqli_query($conn,"INSERT INTO admin VALUES('$uname','$pas')"))
{
echo "PROBLEM IN INSERTING DATA INTO DATABASE PLEASE TRY AGAIN.";
}
else
{
echo "SUCCESSFULLY ADDED NEW ADMIN.";
}
}
mysqli_close($conn);
?>