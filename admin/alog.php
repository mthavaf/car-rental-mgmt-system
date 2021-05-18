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
$query=mysqli_query($conn,"SELECT * FROM admin WHERE uname='$uname' and password='$pas' ");
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
    <title>Supplier LOGGED IN</title>
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
#sign1{
	display:none;
}
#sign2{
	display:none;
}#sign3{
	display:none;
}
#sign4{
	display:none;
}
</style>

  </head>
  <body>
<ul>
  <li><a  href="/dbPro/adminhome.html">Home</a></li>
  <li><a href="admin.html">Logout</a></li>
  <li><a href="acp.html">ChangePassword</a></li>
  <li><a href="arac.html">RemoveAccount</a></li>
  <li><a href="aac.html">ADDAccount</a></li>
</ul>
      <div class="heading" id="heading">
	  <?php
	  if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname=$_POST['userName'];
	  echo "HELLO $uname,";
	  }
	  ?>
	  </div>
	   <p>MANAGE YOUR </p>
	  <button id="clk1" onclick="displaycus()">CUSTOMER</button>
	  <button id="clk2" onclick="displaysup()">SUPPLIER</button>
	  <button id="clk3" onclick="displayorg()">ORGANIZATION</button>
	  <button id="clk4" onclick="displaytra()">TRANSACTION DETAILS</button>
	  
	  
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	 <!-- <script> $(document).ready(function(){
		  
		    $("#sign3").hide();
	  $("#sign1").hide(); $("#sign2").hide();
	   });</script>-->
	  <script>
	  $(document).ready(function(){
$("#clk2").click(function(){
    $("#sign3").hide();
	  $("#sign1").hide();
	  $("#sign4").hide();
});
	});</script>
	
	   <script>
	  $(document).ready(function(){
$("#clk1").click(function(){
    $("#sign3").hide();
	  $("#sign2").hide();
	  $("#sign4").hide();
});
	});
	</script>
	<script>
	  $(document).ready(function(){
$("#clk3").click(function(){
    $("#sign2").hide();
	  $("#sign1").hide();
	  $("#sign4").hide();
});
	});
	</script>
<script>
	  $(document).ready(function(){
$("#clk4").click(function(){
    $("#sign2").hide();
	  $("#sign1").hide();
	  $("#sign3").hide();
});
	});
	</script>	
	  <div id="sign1" class="sign1">
	<br>  
<?php
$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());

$query=mysqli_query($conn,"SELECT uname FROM customer ");
echo "NUMBER OF CUSTOMER'S AVAILABLE. ";
while($row=mysqli_fetch_row($query))
{
	foreach($row as $u)
	echo nl2br("\n$u");
}


mysqli_close($conn);
?>	  
		<form action="arc.php" method="POST" ><br>
	<p>TO remove customer enter username</p>
	<p style="color:black">
	
		USER NAME:<input type="text" name="uname" required><br />
       </p>	
	   <input type="submit" value="REMOVE">
	   </form>
	</div>
	
	
	<div id="sign2" class="sign2"> 
		<br><?php

$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());


$query=mysqli_query($conn,"SELECT uname FROM supplier ");
echo "NUMBER OF SUPPLIER'S AVAILABLE. ";
while($row=mysqli_fetch_row($query))
{
	foreach($row as $u)
	echo nl2br("\n$u");
}

mysqli_close($conn);
?>	
		<form action="ars.php" method="POST" enctype="multipart/form-data"><br>
		<p>TO remove supplier enter username</p>
	<p style="color:black">
	
		USER NAME:<input type="text" name="uname" required><br />
       </p>	
	   <input type="submit" value="REMOVE">
	   </form>
	</div>
	
	<div id="sign3" class="sign3"> 
	<br><?php

$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());

$query=mysqli_query($conn,"SELECT uname FROM organization ");
echo "NUMBER OF ORGANIZATION'S AVAILABLE. ";
while($row=mysqli_fetch_row($query))
{
	foreach($row as $u)
	echo nl2br("\n$u");
}

mysqli_close($conn);
?>	
		<form action="aro.php" method="POST" enctype="multipart/form-data"><br>
		<p>TO remove organization enter username</p>
	<p style="color:black">
	
		USER NAME:<input type="text" name="uname" required><br />
       </p>	
	   <input type="submit" value="REMOVE">
	   </form>
	</div>
	
	<div id="sign4" class="sign4"> 
	<br>
	<?php

$servername="localhost";
$user="root";
$passwd="";
$db="car";
$conn=mysqli_connect($servername,$user,$passwd,$db) or die(mysqli_connect_error());
$query=mysqli_query($conn,"SELECT * FROM transaction ");
echo "NUMBER OF TRANSACTION'S AVAILABLE. ";
while($row=mysqli_fetch_row($query))
{
	foreach($row as $u)
	echo nl2br("$u\t");
	echo"<br>";
}

mysqli_close($conn);
?>	
		<form action="aut.html" method="POST" enctype="multipart/form-data"><br>
		<p>TO update transaction enter username</p>
	<p style="color:black">
	
		USER NAME:<input type="text" name="uname" required><br />
       </p>	
	   <input type="submit" value="REMOVE">
	   </form>
	</div>
	<script type="text/javascript" src="admint.js">

		</script>
	<script type="text/javascript" src="adminc.js">

		</script>
		<script type="text/javascript" src="admins.js">

		</script>
		<script type="text/javascript" src="admino.js">

		</script>
	</body>
	</html>