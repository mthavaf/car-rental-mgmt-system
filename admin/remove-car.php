<?php
include '../config.php';
$conn = getDBConnection();
session_start();
$uname = $_SESSION['uname'];

// Check if there are other admins
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM admin");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];
$stmt->close();

if ($count > 1) {
    $stmt = $conn->prepare("DELETE FROM admin WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    if (!$stmt->execute()) {
        echo "PROBLEM IN REMOVING YOUR ACCOUNT.";
    } else {
        echo "SUCCESSFULLY REMOVED YOUR ACCOUNT.";
        session_unset();
        session_destroy();
    }
    $stmt->close();
} else {
    echo "YOU ARE THE ONLY ADMIN PRESENT. INTRODUCE NEW ADMIN THEN REMOVE YOUR ACCOUNT.";
}
$conn->close();
?>
	mysqli_close($conn);
?>
	<html>
	<body>
	<p>GO BACK TO HOME PRESS HOME BUTTON</p>
	<a href="/dbPro/home.html"> HOME </a>
	</body>
	</html>
	