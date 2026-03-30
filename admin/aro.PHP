<?php
include '../config.php';
$conn = getDBConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];

    // Check if organization exists
    $stmt = $conn->prepare("SELECT uname FROM organization WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "ENTERED USER NAME IS NOT PRESENT.";
        exit(0);
    }
    $stmt->close();

    // Check if organization has cars that are currently rented
    $stmt = $conn->prepare("SELECT t.id FROM transaction t JOIN organization o ON t.car_id = o.car_id WHERE o.uname = ? AND t.todate >= CURDATE()");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "ORGANIZATION HAS CARS THAT ARE CURRENTLY RENTED. REMOVE AFTER THEY ARE RETURNED.";
        exit(0);
    }
    $stmt->close();

    // Delete organization
    $stmt = $conn->prepare("DELETE FROM organization WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    if (!$stmt->execute()) {
        echo "PROBLEM IN REMOVING ORGANIZATION DATA.";
    } else {
        echo "SUCCESSFULLY REMOVED. PRESS BACK TO MAINTAIN.";
    }
    $stmt->close();
}
$conn->close();
?>