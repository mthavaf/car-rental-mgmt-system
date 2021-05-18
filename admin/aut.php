<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();
$uname=$_SESSION["uname"];
$count=mysqli_query($conn,"SELECT * FROM transaction WHERE uname='$uname'") ;
$count=mysqli_num_rows($count);
if($count==0 && $count > 1)
{
echo "ENTERED USER NAME IS INCORRECT";
exit(0);
}
if(!mysqli_query($conn,"UPDATE transaction SET booked='NO' WHERE uname='$uname'") )
{
echo "PROBLEM IN UPDATING TABLE.";
}
else
{
echo "UPDATED SUCCESSFULLY.";
}
?>
<html>
<head>
<title>update</title>
</head>
<body>
</body>
</html>

