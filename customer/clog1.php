<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_POST['userName'];
$_SESSION["uname"]=$uname;
$pas=$_POST['password'];
$query=mysqli_query($conn,"SELECT * FROM customer WHERE uname='$uname' and password='$pas' ");
$query=mysqli_num_rows($query);

if($query!=1)
{
	echo "<script>alert('Username or Password is incorrect');window.location.replace('customer.html');</script>";
exit (0);
}

}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CUSTOMER LOGGED IN</title>
    <link rel="stylesheet" href="customer.css">
	<style>
	ul {
    list-style-type: none;
    margin: 0px;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}
</style>

  </head>
  <body>
<ul>
  <li><a  href="/dbPro/home.html">Home</a></li>
  <li><a href="customer.html">Logout</a></li>
  <li><a href="ccp.html">ChangePassword</a></li>
  <li><a href="cra.html">RemoveAccount</a></li>
 
</ul>
      <div class="heading" id="heading">
	  <?php
	  if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_POST['userName'];
	  echo "HELLO $uname,";
	  }
	  ?>
 </div>
<div>
<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
$id=mysqli_query($conn,"SELECT * FROM car_list");
$num=mysqli_query($conn,"SELECT * FROM car_list");
$num=mysqli_num_rows($num);
$a=mysqli_fetch_assoc($id);
$b=$a['id'];
$c=0;
$l=$num;
$count=0;
echo "<table>";
while($l!=0){
	if($c!=0){
	$a=mysqli_query($conn,"SELECT * FROM car_list WHERE id=$b");
	}
	if($c!=0){
	$a=mysqli_fetch_assoc($a);
	$b=$a['id'];
	}
$car_id=$a['car_id'];
$fuel=$a['fuel'];
$fare=$a['fare'];
$availability=$a['booked'];

if($count%2==0){
	echo "<tr>";
}
if($b!=0){
	echo "<td>";
    echo "<img src=get.php?id=$b height='100' width='200'/>";
	echo "</td>";
	echo "<td></td>";
	echo "<td>$car_id<br>$fuel<br>$fare rs/km<br>BOOKED=$availability<br>";
	echo "<form action='next.php' method='post'><input type='submit' value='RENT'> <input type='hidden' name='access' value='$car_id'></form></td>";
	echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
	echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
	echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
	echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";echo "<td></td>";
	//$ll=0;
	$l =$l-1;
	$count ++;
	}
	if($count%2 == 0){
		echo "</tr>";
	}
$c=$c+1;
$b=$b+1;
}
echo "</table>";

?>
</div>
		</body>
		</html>