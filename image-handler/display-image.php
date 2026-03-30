<?php
include '../config.php';
$conn = getDBConnection();
$query = mysqli_query($conn, "SELECT image FROM image");
header("Content-type: image/jpeg");
while ($r = mysqli_fetch_row($query)) {
    foreach ($r as $i) {
        echo $i; // Output image data directly
    }
}
$conn->close();
?>