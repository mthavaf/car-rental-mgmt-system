<?php
include '../config.php';
$conn = getDBConnection();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $opas = $_POST['opas'];
    $uname = $_SESSION["uname"];
    $new = password_hash($_POST['npas'], PASSWORD_DEFAULT);

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