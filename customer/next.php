<html>
<head>
<title>UPDATE TRANSACTION</title>
</head>
<body>
<p>ENTER FROM AND TO DATE</p>
<form action="next1.php" method="post">
FROM:<input type="text" name="from" placeholder="YYYY-MM-DD"><br><br>
TO:<input type="text" name="to" placeholder="YYYY-MM-DD"><br><br>

<?php
$carid=$_POST['access'];
echo "<input type='hidden' name='carid' value='$carid' >";
?>
<input type="submit" value="SUBMIT" ></form>
</body>
</html>

