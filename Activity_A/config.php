<?php
// Database configuration for Activity A
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sa3_activity_a';

// Create connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    // Select the database
    $conn->select_db($database);
    
    // Create users table if it doesn't exist
    $create_table = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($create_table)) {
        // Insert default admin user if not exists
        $check_admin = "SELECT id FROM users WHERE username = 'admin'";
        $result = $conn->query($check_admin);
        
        if ($result->num_rows == 0) {
            $hashed_password = password_hash('password123', PASSWORD_DEFAULT);
            $insert_admin = "INSERT INTO users (firstname, lastname, email, username, password) VALUES 
                           ('Admin', 'User', 'admin@example.com', 'admin', '$hashed_password')";
            $conn->query($insert_admin);
        }
    } else {
        die("Error creating table: " . $conn->error);
    }
} else {
    die("Error creating database: " . $conn->error);
}

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
