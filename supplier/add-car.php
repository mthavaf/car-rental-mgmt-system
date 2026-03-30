<?php
include '../config.php';
$conn = getDBConnection();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";
$isError = true;

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
        $message = implode("<br>", array_map('htmlspecialchars', $errors));
    } else {
        $file = $_FILES['image']['tmp_name'];

        if (!isset($file) || empty($file)) {
            $message = "Please select an image.";
        } else {
            $image_size = getimagesize($file);
            if ($image_size === FALSE) {
                $message = "That's not a valid image.";
            } else {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $max_size = 5 * 1024 * 1024; // 5MB

                if (!in_array($image_size['mime'], $allowed_types)) {
                    $message = "Only JPEG, PNG, and GIF images are allowed.";
                } else if ($_FILES['image']['size'] > $max_size) {
                    $message = "Image size must be less than 5MB.";
                } else {
                    $image = file_get_contents($file);
                    $stmt = $conn->prepare("INSERT INTO car_list (car_id, name, uname, image, fuel, fare, booked) VALUES (?, ?, ?, ?, ?, ?, 'NO')");
                    $stmt->bind_param("sssssd", $reg, $cname, $uname, $image, $fuel, $fare);
                    
                    if (!$stmt->execute()) {
                        $message = "Problem uploading image to database.";
                    } else {
                        $message = "Successfully added new vehicle to the fleet.";
                        $isError = false;
                    }
                    $stmt->close();
                }
            }
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Action Result | Premium Fleet</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="supplier.css">
    <style>
        .result-box {
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 20px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            margin: auto;
            margin-top: 15vh;
            color: #fff;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        .error-msg { color: #ef4444; }
        .success-msg { color: #10b981; }
        .result-box p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .btn-back {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-back:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="result-box">
        <?php if($isError): ?>
            <h2 class="error-msg" style="margin-bottom:1rem;">Oops, an error occurred</h2>
        <?php else: ?>
            <h2 class="success-msg" style="margin-bottom:1rem;">Success!</h2>
        <?php endif; ?>
        
        <p><?php echo $message; ?></p>
        
        <a href="login.php" class="btn-back">Go Back to Dashboard</a>
    </div>
</body>
</html>