<?php
include '../config.php';
$conn = getDBConnection();
session_start();
$uname = $_SESSION['uname'];

$stmt = $conn->prepare("DELETE FROM supplier WHERE uname = ?");
$stmt->bind_param("s", $uname);
if ($stmt->execute()) {
    $stmt->close();
    $stmt = $conn->prepare("DELETE FROM car_list WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    echo "YOUR ACCOUNT HAS BEEN REMOVED.";
} else {
    echo "Error removing account.";
}
$stmt->close();
$conn->close();
?>
else
{ echo "PROBLEM IN REMOVING YOUR ACCOUNT.";
}
session_unset();
session_destroy();
	mysqli_close($conn);
	?>
	<html>
	<body>
	<p>GO BACK TO HOME PRESS HOME BUTTON</p>
	<a href="/dbPro/home.html"> HOME </a>
	</body>
	</html>
	