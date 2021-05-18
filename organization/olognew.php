<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_SESSION['uname'];
$cname=$_POST['name'];
$reg=$_POST['carid'];
$fuel=$_POST['fuel'];
$fare=$_POST['fare'];
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
    if (!$insert = mysqli_query($conn,"INSERT INTO car_list VALUES ('$reg', '$cname','$uname','$image', '$fuel','$fare')"))
        echo "Problem Uploading Image.";
		
		else
		{
		echo "Successfully completed.";
	
		}
		}
		}
		}
		mysqli_close($conn);
		?>
				<html>
		<body>
		<p> GO back to </p><a href="olog1.php">back</a>
</body>
</html>	