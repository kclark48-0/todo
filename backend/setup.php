<?php
$host = "localhost"; // Change if using a different DB host
$user = "root"; // Change to your user
$pass = ""; // Change to your password
$dbname = "todo_app";

// Connect to MySQL (MySQL must be running first)
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    //echo "Database checked/created successfully.\n"
    ;
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create tasks table if it doesn’t exist
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Check if table has been created
if ($conn->query($sql) === TRUE) {
    //echo "Table checked/created successfully.\n"
    ;
} else {
    die("Error creating table: " . $conn->error);
}

// Close connection
$conn->close();
?>
