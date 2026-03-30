<?php
include '../config.php';
$conn = getDBConnection();

// Handle logout first
if (isset($_GET['logout'])) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    header("Location: supplier.html");
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = trim($_POST['userName']);
    $pas = trim($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM supplier WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if (password_verify($pas, $row['password']) || $pas === $row['password']) {
            $_SESSION["uname"] = $uname;
            $_SESSION["login_time"] = time(); // Store login time for timeout
            // ONLY regenerate id if headers have not been sent (to avoid warnings)
            if (!headers_sent()) {
                session_regenerate_id(true); // Regenerate session ID for security
            }
        } else {
            echo "<div style='color: red; font-size: 18px; text-align: center; margin: 20px;'>USERNAME OR PASSWORD IS INVALID. <a href='supplier.html'>PRESS BACK TO LOGIN AGAIN</a></div>";
            exit(0);
        }
    } else {
        echo "<div style='color: red; font-size: 18px; text-align: center; margin: 20px;'>USERNAME OR PASSWORD IS INVALID. <a href='supplier.html'>PRESS BACK TO LOGIN AGAIN</a></div>";
        exit(0);
    }
    $stmt->close();
}

// Check session for dashboard access
if (!isset($_SESSION['uname']) || !checkSessionTimeout()) {
    header("Location: supplier.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard | Premium Fleet</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="supplier.css">
    <style>
        .navbar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 0;
        }

        .navbar li {
            position: relative;
        }

        .navbar a {
            display: inline-block;
            color: #94a3b8;
            padding: 1.25rem 2rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
        }

        .navbar a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .dashboard-container {
            margin-top: 100px;
            width: 100%;
            max-width: 800px;
            padding: 2rem;
            z-index: 10;
        }

        .welcome-box {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(255,255,255,0.05);
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .welcome-box h2 {
            font-size: 2.2rem;
            color: #fff;
            margin-bottom: 1rem;
        }

        .welcome-box h2 span {
            color: #3b82f6;
        }

        .welcome-box p {
            color: #94a3b8;
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .action-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-bottom: 2.5rem;
        }

        .action-buttons button {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .action-buttons button:hover {
            background: #3b82f6;
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .form-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            display: none;
            animation: slideUp 0.4s ease forwards;
        }

        .form-panel.active {
            display: block;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-panel h3 {
            margin-bottom: 1.5rem;
            color: #fff;
            font-size: 1.5rem;
            text-align: center;
        }

        select {
            width: 100%;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 0.85rem 1rem;
            color: #f8fafc;
            font-size: 1rem;
            outline: none;
            transition: all 0.2s ease;
            margin-bottom: 1.5rem;
            cursor: pointer;
        }

        select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        select option {
            background: #0f172a;
            color: #f8fafc;
        }

        .help-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: -1rem;
            margin-bottom: 1rem;
            display: block;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <ul>
            <li><a href="../index.html">Home</a></li>
            <li><a href="login.php?logout=1">Logout</a></li>
            <li><a href="change-password.php">Change Password</a></li>
            <li><a href="remove-account.php">Remove Account</a></li>
        </ul>
    </nav>

    <div class="dashboard-container">
        
        <div class="welcome-box">
            <h2>Welcome back, <span><?php echo isset($_SESSION['uname']) ? htmlspecialchars($_SESSION['uname']) : 'Supplier'; ?></span></h2>
            <p>Manage your fleet inventory efficiently. You can add new vehicles to your company listings or remove existing ones.</p>
        </div>

        <div class="action-buttons">
            <button onclick="togglePanel('addForm')">Add New Car</button>
            <button onclick="togglePanel('removeForm')">Remove Car</button>
        </div>

        <!-- Add Car Form -->
        <div id="addForm" class="form-panel">
            <h3>Add a Vehicle</h3>
            <form action="add-car.php" method="POST" enctype="multipart/form-data">
                
                <label>Car Registration Number</label>
                <input type="text" name="carid" required placeholder="E.g. xx-xx x-xxxx">
                <span class="help-text">Please enter the exact license plate format.</span>

                <label>Car Name / Model</label>
                <input type="text" name="name" required placeholder="E.g. Honda Civic">

                <label>Upload Car Image (JPEG/PNG)</label>
                <input type="file" name="image" class="file-input" required>

                <label>Fuel Type</label>
                <select name="fuel" required>
                    <option value="" disabled selected>Select Fuel Type</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                    <option value="Hybrid">Hybrid</option>
                </select>

                <label>Fare (Rs/Km)</label>
                <input type="number" name="fare" required placeholder="Enter expected fare rate" min="1" max="10000">

                <button type="submit" class="btn btn-primary" style="margin-top:1rem;">Add Vehicle to Fleet</button>
            </form>
        </div>

        <!-- Remove Car Form -->
        <div id="removeForm" class="form-panel">
            <h3>Remove a Vehicle</h3>
            <form action="remove-car.php" method="POST">
                <label>Car ID / Registration Number</label>
                <input type="text" name="carid" required placeholder="Enter exact Car ID to remove">
                
                <button type="submit" class="btn btn-primary" style="background:#ef4444; margin-top:1rem;">Remove Vehicle</button>
            </form>
        </div>

    </div>

    <script>
        function togglePanel(panelId) {
            document.getElementById('addForm').classList.remove('active');
            document.getElementById('removeForm').classList.remove('active');
            
            // Add slight delay for animation smoothness
            setTimeout(() => {
                document.getElementById(panelId).classList.add('active');
            }, 50);
        }
    </script>
</body>
</html>
		