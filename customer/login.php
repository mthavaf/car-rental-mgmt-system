<?php
include '../config.php';
$conn = getDBConnection();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['userName'];
    $pas = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM customer WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($pas, $row['password'])) {
            $_SESSION["uname"] = $uname;
        } else {
            echo "<script>alert('Username or Password is incorrect');window.location.replace('customer.html');</script>";
            exit(0);
        }
    } else {
        echo "<script>alert('Username or Password is incorrect');window.location.replace('customer.html');</script>";
        exit(0);
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>CUSTOMER LOGGED IN</title>
	<link rel="stylesheet" href="customer.css">
	<style>
		ul {
			list-style-type: none;
			margin: 0px;
			padding: 0;
			overflow: hidden;
			background-color: #333;
		}

		li {
			float: left;
		}

		li a {
			display: inline-block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		li a:hover {
			background-color: #111;
		}
	</style>

</head>

<body>
	<ul>
		<li><a href="/dbPro/home.html">Home</a></li>
		<li><a href="customer.html">Logout</a></li>
		<li><a href="ccp.html">ChangePassword</a></li>
		<li><a href="cra.html">RemoveAccount</a></li>

	</ul>
	<div class="heading" id="heading">
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$uname = $_POST['userName'];
			echo "HELLO $uname,";
		}
		?>
	</div>
	<div>
		<?php
		include '../config.php';
		$conn = getDBConnection();
		$result = $conn->query("SELECT * FROM car_list");
		$num = $result->num_rows;
		$count = 0;
		echo "<table>";
		while ($row = $result->fetch_assoc()) {
			$car_id = $row['car_id'];
			$fuel = $row['fuel'];
			$fare = $row['fare'];
			$availability = $row['booked'];
			$id = $row['id'];

			if ($count % 2 == 0) {
				echo "<tr>";
			}
			echo "<td>";
			echo "<img src='get-image.php?id=$id' height='100' width='200'/>";
			echo "</td>";
			echo "<td>$car_id<br>$fuel<br>$fare rs/km<br>BOOKED=$availability<br>";
			echo "<form action='book-car.php' method='post'><input type='submit' value='RENT'> <input type='hidden' name='access' value='$car_id'></form></td>";
			// Remove extra <td> tags
			echo "</tr>";
			$count++;
		}
		echo "</table>";
		$conn->close();
		?>
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				//$ll=0;
				$l = $l - 1;
				$count++;
			}
			if ($count % 2 == 0) {
				echo "</tr>";
			}
			$c = $c + 1;
			$b = $b + 1;
		}
		echo "</table>";

		?>
	</div>
</body>

</html>