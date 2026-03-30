<?php
include '../config.php';
$conn = getDBConnection();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $carid = trim($_POST['carid']);
    $from = trim($_POST['from']);
    $to = trim($_POST['to']);
    $uname = $_SESSION["uname"];

    // Validation
    $errors = [];

    if (empty($carid) || strlen($carid) > 20) {
        $errors[] = "Invalid car ID.";
    }

    if (empty($from) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) {
        $errors[] = "Valid from date is required (YYYY-MM-DD format).";
    }

    if (empty($to) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
        $errors[] = "Valid to date is required (YYYY-MM-DD format).";
    }

    if (empty($errors)) {
        $from_date = new DateTime($from);
        $to_date = new DateTime($to);
        $today = new DateTime();

        if ($from_date < $today) {
            $errors[] = "From date cannot be in the past.";
        }

        if ($to_date <= $from_date) {
            $errors[] = "To date must be after from date.";
        }

        // Check if car is available for the dates
        $stmt_check = $conn->prepare("SELECT id FROM transaction WHERE car_id = ? AND ((fromdate <= ? AND todate >= ?) OR (fromdate <= ? AND todate >= ?) OR (fromdate >= ? AND todate <= ?))");
        $stmt_check->bind_param("sssssss", $carid, $from, $from, $to, $to, $from, $to);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "Car is not available for the selected dates.";
        }
        $stmt_check->close();
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . "<br>";
        }
        exit(0);
    }

    $stmt = $conn->prepare("INSERT INTO transaction (uname, car_id, fromdate, todate) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $uname, $carid, $from, $to);
    if (!$stmt->execute()) {
        echo "PROBLEM IN BOOKING. BOOK SOME OTHER TIME.";
    } else {
        echo "SUCCESSFULLY BOOKED YOUR FAVOURITE CAR. YOU CAN RECEIVE YOUR CAR AT OUR OFFICE. CONTACT US.";
    }
    $stmt->close();
}
$conn->close();
?>