<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_POST['uname'];
$count=mysqli_query($conn,"SELECT * FROM customer where uname='$uname'");
$count=mysqli_num_rows($count);
if($count==0)
{
	echo "ENTERED USER NAME IS NOT PRESENT.";
	exit(0);
}
$num=mysqli_query($conn,"SELECT * FROM transaction where uname='$uname'");
if($num!=0)
{
	echo "CUSTOMER BOOKED CAR TRY REMOVING AFTER HE RETURNED.";
	exit(0);
}
		if(!mysqli_query($conn,"DELETE FROM customer where uname='$uname'"))
		{
			echo "PROBLEM IN REMOVING CUSTOMER DATA";
		}
		else
			echo "SUCCESSFULLY RMOVED PRESS BACK TO MAINTAIN";

}
mysqli_close($conn);
?>