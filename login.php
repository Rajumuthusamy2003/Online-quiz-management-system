<?php
// Start the session
session_start();

// Get the input data
$email = trim($_POST['email']);
$pwd = trim($_POST['password']);

// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "quiz"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("SELECT password FROM signup WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows > 0) {
    // Bind result variable
    $stmt->bind_result($stored_password);
    $stmt->fetch();

    // Check if the entered password matches the stored password
    if ($pwd === $stored_password) {
        // Password is correct, redirect to language choose page
        header("Location: languagechoose.html");
        exit();
    } else {
        // Invalid password
        echo 'Sorry, this login is invalid';
    }
} else {
    // Email not found
    echo 'Sorry, this login is invalid';
}

// Close connections
$stmt->close();
$conn->close();
?>
