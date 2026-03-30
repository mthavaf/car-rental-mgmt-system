<?php
include '../config.php';
$conn = getDBConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $oname = trim($_POST['name']);
    $ph = trim($_POST['phNo']);
    $mail = trim($_POST['mailId']);
    $uname = trim($_POST['userName']);
    $pas = $_POST['password'];

    // Validation
    $errors = [];

    if (empty($oname) || strlen($oname) > 100) {
        $errors[] = "Organization name is required and must be less than 100 characters.";
    }

    if (empty($ph) || !preg_match('/^[0-9+\-\s()]{10,15}$/', $ph)) {
        $errors[] = "Valid phone number is required (10-15 digits).";
    }

    if (empty($mail) || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required.";
    }

    if (empty($uname) || strlen($uname) < 3 || strlen($uname) > 30 || !preg_match('/^[a-zA-Z0-9_]+$/', $uname)) {
        $errors[] = "Username must be 3-30 characters, alphanumeric with underscores only.";
    }

    if (empty($pas) || strlen($pas) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . "<br>";
        }
        exit(0);
    }

    $pas = password_hash($pas, PASSWORD_DEFAULT);

    // Check if username exists
    $stmt = $conn->prepare("SELECT uname FROM supplier WHERE uname = ? UNION SELECT uname FROM customer WHERE uname = ? UNION SELECT uname FROM organization WHERE uname = ?");
    $stmt->bind_param("sss", $uname, $uname, $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "CHOOSE DIFFERENT USER NAME...AND PRESS BACK TO CONTINUE YOUR REGISTRATION";
        exit(0);
    }
    $stmt->close();

    $file = $_FILES['adhar']['tmp_name'];
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

    if ($_FILES['adhar']['size'] > $max_size) {
        echo "Image size must be less than 5MB.";
        exit(0);
    }

    $image = file_get_contents($file);

    $stmt = $conn->prepare("INSERT INTO organization (oname, ph, mail, image, uname, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $oname, $ph, $mail, $image, $uname, $pas);
    if (!$stmt->execute()) {
        echo "Problem uploading your data into database. Try again.";
        exit(0);
    }
    $stmt->close();

    echo "Successfully Registered";
}
$conn->close();
?>

<html>

<head>
	<title>Successfull</title>
</head>

<body>
	<br />
	<h1>PRESS CLICK ME TO LOGIN .... </h1><br /><a href="organization.html"> CLICK ME</a>
</body>

</html>