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
            $stmt->bind_param("sb", $image_name, $image);
            if (!$stmt->execute()) {
                echo "Problem Uploading Image.";
            } else {
                $last_id = $conn->insert_id;
                $stmt->close();
                $stmt = $conn->prepare("SELECT image FROM image WHERE id = ?");
                $stmt->bind_param("i", $last_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_row()) {
                    echo $row[0]; // Output image data
                }
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>
