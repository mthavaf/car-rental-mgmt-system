<?php
include '../config.php';
$conn = getDBConnection();
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_SESSION['uname'];
    $cid = $_POST['carid'];

    $stmt = $conn->prepare("SELECT car_id FROM car_list WHERE uname = ? AND car_id = ?");
    $stmt->bind_param("ss", $uname, $cid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM car_list WHERE uname = ? AND car_id = ?");
        $stmt->bind_param("ss", $uname, $cid);
        if ($stmt->execute()) {
            echo "Successfully removed. Press back to continue.";
        } else {
            echo "Problem in removing your car. Try again later.";
        }
    } else {
        echo "CAR ID entered is incorrect.";
    }
    $stmt->close();
}
$conn->close();
?>