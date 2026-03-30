<?php
include '../config.php';
$conn = getDBConnection();
session_start();
$uname = $_SESSION["uname"];

$stmt = $conn->prepare("SELECT COUNT(*) as count FROM transaction WHERE uname = ?");
$stmt->bind_param("s", $uname);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];
$stmt->close();

if ($count == 0) {
    echo "NO TRANSACTIONS FOUND FOR THIS USER.";
    exit(0);
}

$stmt = $conn->prepare("UPDATE transaction SET booked = 'NO' WHERE uname = ?");
$stmt->bind_param("s", $uname);
if (!$stmt->execute()) {
    echo "PROBLEM IN UPDATING TABLE.";
} else {
    echo "UPDATED SUCCESSFULLY.";
}
$stmt->close();
$conn->close();
?>
<html>
<head>
<title>Update Transaction</title>
</head>
<body>
</body>
</html>
</html>

