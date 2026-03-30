<?php
include '../config.php';
$conn = getDBConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];

    // Check if supplier exists
    $stmt = $conn->prepare("SELECT uname FROM supplier WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "ENTERED USER NAME IS NOT PRESENT.";
        exit(0);
    }
    $stmt->close();

    // Check if supplier has active rentals
    $stmt = $conn->prepare("SELECT t.id FROM transaction t JOIN car_list c ON t.car_id = c.car_id WHERE c.uname = ? AND t.todate >= CURDATE()");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "CUSTOMER RENTED HIS CAR. REMOVE AFTER THEY RETURNED.";
        exit(0);
    }
    $stmt->close();

    // Delete supplier
    $stmt = $conn->prepare("DELETE FROM supplier WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    if (!$stmt->execute()) {
        echo "PROBLEM IN REMOVING SUPPLIER DATA.";
    } else {
        echo "SUCCESSFULLY REMOVED. PRESS BACK TO MAINTAIN.";
    }
    $stmt->close();
}
$conn->close();
?>
mysqli_close($conn);
?>