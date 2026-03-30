<?php
include '../config.php';
$conn = getDBConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $uname = trim($_POST['uname']);
    $pas = $_POST['password'];

    // Validation
    $errors = [];

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

    $stmt = $conn->prepare("INSERT INTO admin (uname, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $uname, $pas);
    if (!$stmt->execute()) {
        echo "PROBLEM IN INSERTING DATA INTO DATABASE. PLEASE TRY AGAIN.";
    } else {
        echo "SUCCESSFULLY ADDED NEW ADMIN.";
    }
    $stmt->close();
}
$conn->close();
?>