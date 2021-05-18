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
$query=mysqli_query($conn,"SELECT * FROM organization WHERE uname='$uname' and password='$pas' ");
$query=mysqli_num_rows($query);

if($query!=1)
{
	echo "USERNAME OR PASSWORD IS INVALID. PRESS BACK TO LOGIN AGAIN";
exit (0);
}

}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Organization LOGGED IN</title>
    <link rel="stylesheet" href="organization.css">
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
  <li><a href="organization.html">Logout</a></li>
  <li><a href="ocp.html">ChangePassword</a></li>
  <li><a href="orac.html">RemoveAccount</a></li>
</ul>
      <div class="heading" id="heading">
	  <?php
	  if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_POST['userName'];
	  echo "HELLO $uname,";
	  }
	  ?>
	  
      </div>
	  <p>IF YOU WANT TO ADD YOUR CAR TO COMPANY CLICK ON ADD BUTTON OR TO REMOVE YOUR CAR CLICK ON REMOVE BUTTON</p>
	  <button id="clk1" onclick="displaySignUpForm()">ADD CAR</button>
	  <button id="clk2" onclick="displaysign()">REMOVE  CAR</button>
	  
	  
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script>
	  $(document).ready(function(){
$("#clk2").click(function(){
    $("#signUpForm").hide();
});
	});</script>
	
	   <script>
	  $(document).ready(function(){
$("#clk1").click(function(){
    $("#sign").hide();
});
	});</script>
	
	  
	  
	  <div id="signUpForm" class="signUpForm" >
        <form action="olognew.php" method="POST" enctype="multipart/form-data">
		<p style="color:black">
		CAR REG NO:<br><input type="text" name="carid" required><br />
		E.g(xx-xx x-xxxx)<br />
		CAR NAME:<br><input type="text" name="name" required><br />
		
		UPLOAD YOUR CAR PIC:<br />
		<input type="file" name="image" required><br />
		FUEL:<br><input type="text" name="fuel" required><br />
		FARE:<br><input type="text" name="fare" required><br />
</p>		<input type="submit" value="ADD">
		</form>
		</div>
		
		<div id="sign" class="sign"> 
		<form action="olognew1.php" method="POST" enctype="multipart/form-data">
	
	<p style="color:black">
		
		CAR ID:<input type="text" name="carid" required><br />
       </p>	
	   <input type="submit" value="REMOVE">
	   </form>
	</div>
	
	<script type="text/javascript" src="sremove.js">

		</script>

		<script type="text/javascript" src="organization.js">

		</script>
		</body>
		</html>