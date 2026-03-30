<?php
include '../config.php';
$conn = getDBConnection();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $opas = $_POST['opas'];
    $npas = $_POST['npas'];
    $rpas = $_POST['rpas'];
    $uname = $_SESSION["uname"];

    // Validation
    $errors = [];

    if (empty($opas)) {
        $errors[] = "Old password is required.";
    }

    if (empty($npas) || strlen($npas) < 6) {
        $errors[] = "New password must be at least 6 characters long.";
    }

    if ($npas !== $rpas) {
        $errors[] = "New passwords do not match.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . "<br>";
        }
        exit(0);
    }

    $new = password_hash($npas, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT password FROM organization WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($opas, $row['password'])) {
            $stmt->close();
            $stmt = $conn->prepare("UPDATE organization SET password = ? WHERE uname = ?");
            $stmt->bind_param("ss", $new, $uname);
            if ($stmt->execute()) {
                echo "Successfully changed.";
            } else {
                echo "Problem while resetting your password. Try again later.";
            }
        } else {
            echo "Enter correct old password.";
        }
    } else {
        echo "User not found.";
    }
    $stmt->close();
}
$conn->close();
?>
<html>

<head>
	<title>Password Changed</title>
</head>

<body>
	<h3>go back to login again</h3>
</body>

</html>