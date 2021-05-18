<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$file = $_FILES['image']['tmp_name'];

if (!isset($file))
    echo "please select an image.";
else
  {
  $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $image_name = $_FILES['image']['name'];
  $image_size = getimagesize($_FILES['image']['tmp_name']); 

  if($image_size==FALSE)
    echo "That's not an image.";
  else
  {
    if (!$insert = mysqli_query($conn,"INSERT INTO image VALUES ('', '$image_name', '$image')"))
        echo "Problem Uploading Image.";
    else
        {
		$query=mysqli_query($conn,"SELECT image FROM image WHERE id=$ll");
while($r=mysqli_fetch_row($query))
{
foreach ($r as $i)
{
echo "$i";
}
}
