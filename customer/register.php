
<?php
include '../config.php';
$conn = getDBConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $ph = $_POST['phNo'];
    $mail = $_POST['mailId'];
    $uname = $_POST['userName'];
    $pas = password_hash($_POST['password'], PASSWORD_DEFAULT);

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

    $image = file_get_contents($file);

    $stmt = $conn->prepare("INSERT INTO customer (fname, lname, ph, mail, image, uname, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fname, $lname, $ph, $mail, $image, $uname, $pas);
    if (!$stmt->execute()) {
        echo "Problem uploading your data into database. Try again.";
        exit(0);
    }
    $stmt->close();

    echo "Successfully Registered";
}
$conn->close();
?>
		echo "Successfully Registered";
		
		}
		}
		}
		}
		mysqli_close($conn);
		?>
		
		<html>
		<head><title>Successfull</title></head>
		<body>
		<br />
		<h1>PRESS CLICK ME  TO LOGIN .... </h1><br /><a href="customer.html"> CLICK ME</a>
		</body>
		</html>