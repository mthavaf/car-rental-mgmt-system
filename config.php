<?php
/**
 * Database Configuration
 * Load from environment variables for security
 */

// Get DB credentials from environment or use defaults
$db_config = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'car_user',
    'password' => getenv('DB_PASSWORD') ?: 'car_password',
    'database' => getenv('DB_NAME') ?: 'car'
];

// Function to get database connection
function getDBConnection() {
    global $db_config;
    
    $conn = new mysqli(
        $db_config['host'],
        $db_config['user'],
        $db_config['password'],
        $db_config['database']
    );
    
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Function for prepared statements (safer)
function executeQuery($query, $params = []) {
    $conn = getDBConnection();
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }
    
    return $stmt;
}

// Session security functions
function checkSessionTimeout($timeout_minutes = 30) {
    if (!isset($_SESSION['login_time'])) {
        return false; // Not logged in
    }
    
    $timeout_seconds = $timeout_minutes * 60;
    if (time() - $_SESSION['login_time'] > $timeout_seconds) {
        session_destroy();
        return false; // Session expired
    }
    
    return true; // Session valid
}

function requireLogin($redirect_url = 'index.html') {
    session_start();
    if (!isset($_SESSION['uname']) || !checkSessionTimeout()) {
        header("Location: $redirect_url");
        exit();
    }
}

?>
