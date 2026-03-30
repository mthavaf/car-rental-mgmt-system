<?php
include '../config.php';
$conn = getDBConnection();
session_start();
$uname = $_SESSION['uname'];

$conn->begin_transaction();
try {
    // Delete from car_list first (foreign key)
    $stmt = $conn->prepare("DELETE FROM car_list WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->close();

    // Delete organization
    $stmt = $conn->prepare("DELETE FROM organization WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo "YOUR ACCOUNT HAS BEEN REMOVED.";
    session_unset();
    session_destroy();
} catch (Exception $e) {
    $conn->rollback();
    echo "PROBLEM IN REMOVING YOUR ACCOUNT.";
}
$conn->close();
?>
<html>
<head>
 <link rel="stylesheet" href="organization.css">
 </head>
<body>
<p>GO BACK TO HOME PRESS HOME BUTTON</p>
<a href="/dbPro/home.html"> HOME </a>
</body>
	</html>
	