<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$carid=$_POST['carid'];
$from=$_POST['from'];
$to=$_POST['to'];
$uname=$_SESSION["uname"];
if(!mysqli_query($conn,"INSERT INTO transaction VALUES('','$uname','$carid','$from','$to')"))
{
echo "PROBLEM IN BOOKING BOOK SOME OTHER TIME.";
}
	else
	echo "SUCCESSFULLY BOOKED YOUR FAVOURITE CAR YOU CAN RECIEVE YOUR CAR AT OUR OFFICE CONTACT US. ";
}
	?>