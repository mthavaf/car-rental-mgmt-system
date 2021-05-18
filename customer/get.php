<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
$id = addslashes($_REQUEST['id']);

$image = mysqli_query($conn,"SELECT * FROM car_list WHERE id=$id");
$image = mysqli_fetch_assoc($image);
$image = $image['image'];
header("Content-type: image/jpeg");

echo $image;

?>