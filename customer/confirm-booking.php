<?php
include '../config.php';
$conn = getDBConnection();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carid = $_POST['carid'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $uname = $_SESSION["uname"];

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