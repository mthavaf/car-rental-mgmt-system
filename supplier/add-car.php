<?php
include '../config.php';
$conn = getDBConnection();
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_SESSION['uname'];
    $cname = $_POST['name'];
    $reg = $_POST['carid'];
    $fuel = $_POST['fuel'];
    $fare = $_POST['fare'];
    $file = $_FILES['image']['tmp_name'];

    if (!isset($file)) {
        echo "Please select an image.";
    } else {
        $image_size = getimagesize($file);
        if ($image_size === FALSE) {
            echo "That's not an image.";
        } else {
            $image = file_get_contents($file);
            $stmt = $conn->prepare("INSERT INTO car_list (car_id, name, uname, image, fuel, fare, booked) VALUES (?, ?, ?, ?, ?, ?, 'NO')");
            $stmt->bind_param("sssssd", $reg, $cname, $uname, $image, $fuel, $fare);
            if (!$stmt->execute()) {
                echo "Problem uploading image.";
            } else {
                echo "Successfully completed.";
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>
<html>
<body>
<p> GO back to </p><a href="login.php">back</a>
</body>
</html>