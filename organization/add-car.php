<?php
include '../config.php';
$conn = getDBConnection();
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $uname = $_SESSION['uname'];
    $cname = trim($_POST['name']);
    $reg = trim($_POST['carid']);
    $fuel = trim($_POST['fuel']);
    $fare = trim($_POST['fare']);

    // Validation
    $errors = [];

    if (empty($cname) || strlen($cname) > 100) {
        $errors[] = "Car name is required and must be less than 100 characters.";
    }

    if (empty($reg) || strlen($reg) > 20 || !preg_match('/^[A-Z0-9\-]+$/', $reg)) {
        $errors[] = "Valid car registration number is required (alphanumeric with dashes, max 20 chars).";
    }

    if (empty($fuel) || !in_array($fuel, ['Petrol', 'Diesel', 'Electric', 'Hybrid'])) {
        $errors[] = "Fuel type must be one of: Petrol, Diesel, Electric, Hybrid.";
    }

    if (empty($fare) || !is_numeric($fare) || $fare <= 0 || $fare > 10000) {
        $errors[] = "Fare must be a positive number less than 10,000.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . "<br>";
        }
        exit(0);
    }

    $file = $_FILES['image']['tmp_name'];

    if (!isset($file)) {
        echo "Please select an image.";
        exit(0);
    }

    $image_size = getimagesize($file);
    if ($image_size === FALSE) {
        echo "That's not an image.";
        exit(0);
    }

    // Additional file validation
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($image_size['mime'], $allowed_types)) {
        echo "Only JPEG, PNG, and GIF images are allowed.";
        exit(0);
    }

    if ($_FILES['image']['size'] > $max_size) {
        echo "Image size must be less than 5MB.";
        exit(0);
    }

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
$conn->close();
?>
				<html>
		<body>
		<p> GO back to </p><a href="olog1.php">back</a>
</body>
</html>	