<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
$query=mysqli_query($conn,"SELECT image FROM image");
header("Content-type: image/jpeg");
while($r=mysqli_fetch_row($query))
{
foreach ($r as $i)
{
echo "<img height='100' weight='100'>.'$i'.";
}
}
?>