<?php
include '../config.php';
$conn = getDBConnection();
$id = $_REQUEST['id'];

$stmt = $conn->prepare("SELECT image FROM car_list WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    header("Content-type: image/jpeg");
    echo $row['image'];
}
$stmt->close();
$conn->close();
?>