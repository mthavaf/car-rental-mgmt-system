<?php
include '../config.php';
$conn = getDBConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    $pas = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin (uname, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $uname, $pas);
    if (!$stmt->execute()) {
        echo "PROBLEM IN INSERTING DATA INTO DATABASE. PLEASE TRY AGAIN.";
    } else {
        echo "SUCCESSFULLY ADDED NEW ADMIN.";
    }
    $stmt->close();
}
$conn->close();
?>