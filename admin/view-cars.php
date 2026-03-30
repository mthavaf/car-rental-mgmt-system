<?php
include '../config.php';
$conn = getDBConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];

    // Check if customer exists
    $stmt = $conn->prepare("SELECT uname FROM customer WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "ENTERED USER NAME IS NOT PRESENT.";
        exit(0);
    }
    $stmt->close();

    // Check if customer has active rentals
    $stmt = $conn->prepare("SELECT id FROM transaction WHERE uname = ? AND todate >= CURDATE()");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "CUSTOMER HAS ACTIVE BOOKINGS. TRY REMOVING AFTER THEY RETURN.";
        exit(0);
    }
    $stmt->close();

    // Delete customer
    $stmt = $conn->prepare("DELETE FROM customer WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    if (!$stmt->execute()) {
        echo "PROBLEM IN REMOVING CUSTOMER DATA.";
    } else {
        echo "SUCCESSFULLY REMOVED. PRESS BACK TO MAINTAIN.";
    }
    $stmt->close();
}
$conn->close();
?>
?>