
<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$oname=$_POST['name'];
$ph=$_POST['phNo'];
$mail=$_POST['mailId'];
$uname=$_POST['userName'];
$pas=$_POST['password'];

$file = $_FILES['adhar']['tmp_name'];
$id=mysqli_query($conn,"SELECT * FROM organization WHERE uname='$uname' ");
$id1=mysqli_query($conn,"SELECT * FROM customer  WHERE uname='$uname' ");
$id2=mysqli_query($conn,"SELECT * FROM organization  WHERE uname='$uname' ");
$r=mysqli_num_rows($id);
$r1=mysqli_num_rows($id1);
$r2=mysqli_num_rows($id2);

if($r!=0 || $r1!=0 || $r2!=0)
{
	
		echo "CHOOSE DIFFERENT USER NAME...AND PRESS BACK TO CONTINUE YOUR REGISTRATION";
		exit(0);
	
}

if (!isset($file))
    echo "please select an image.";
else
  {
  $image = addslashes(file_get_contents($_FILES['adhar']['tmp_name']));
  $image_name = $_FILES['adhar']['name'];
  $image_size = getimagesize($_FILES['adhar']['tmp_name']); 

  if($image_size==FALSE)
    echo "That's not an image.";
  else
  {
    if (!$insert = mysqli_query($conn,"INSERT INTO organization VALUES ('','$oname','$ph','$mail','$image','$uname','$pas')")){
	echo "Problem Uploading your data into database try again. ";
	exit(0);
	}
		else
		{
		echo "Successfully Registered";
		
		}
		}
		}
		}
		mysqli_close($conn);
		?>
		
		<html>
		<head><title>Successfull</title></head>
		<body>
		<br />
		<h1>PRESS CLICK ME  TO LOGIN .... </h1><br /><a href="organization.html"> CLICK ME</a>
		</body>
		</html>