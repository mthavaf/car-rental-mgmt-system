<?php
include '../config.php';
$conn = getDBConnection();
// Handle logout
if (isset($_GET['logout'])) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    header("Location: organization.html");
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = trim($_POST['userName']);
    $pas = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT password FROM organization WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($pas, $row['password']) || $pas === $row['password']) {
            $_SESSION["uname"] = $uname;
            $_SESSION["login_time"] = time(); // Store login time for timeout
            if (!headers_sent()) {
                session_regenerate_id(true); // Regenerate session ID for security
            }
        } else {
            echo "<div style='color: red; font-size: 18px; text-align: center; margin: 20px;'>USERNAME OR PASSWORD IS INVALID. <a href='organization.html'>PRESS BACK TO LOGIN AGAIN</a></div>";
            exit(0);
        }
    } else {
        echo "<div style='color: red; font-size: 18px; text-align: center; margin: 20px;'>USERNAME OR PASSWORD IS INVALID. <a href='organization.html'>PRESS BACK TO LOGIN AGAIN</a></div>";
        exit(0);
    }
    $stmt->close();
}
$conn->close();

// Check session for dashboard access
if (!isset($_SESSION['uname']) || !checkSessionTimeout()) {
    header("Location: organization.html");
    exit();
}
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
  <li><a href="login.php?logout=1">Logout</a></li>
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