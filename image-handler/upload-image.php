<?php
include '../config.php';
$conn = getDBConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_FILES['image']['tmp_name'];

    if (!isset($file)) {
        echo "Please select an image.";
    } else {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $image_name = $_FILES['image']['name'];
        $image_size = getimagesize($_FILES['image']['tmp_name']);

        if ($image_size === FALSE) {
            echo "That's not an image.";
        } else {
            $stmt = $conn->prepare("INSERT INTO image (name, image) VALUES (?, ?)");
            $stmt->bind_param("sb", $image_name, $image); // 'b' for blob
            if (!$stmt->execute()) {
                echo "Problem Uploading Image.";
            } else {
                $last_id = $conn->insert_id;
                echo "<img src='get.php?id=$last_id' height='100' alt='$image_name'>";
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>
<html>
	<body>
	<p>h<br /></p>
	</body></html>