<?php

include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // MD5 hash the password
    $hashed_password = md5($password);

    // Query to fetch user details based on provided username and hashed password
    $sql = "SELECT * FROM customer WHERE username='$username' AND password='$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, redirect to dashboard or home page
        echo "Login successful!";
        // You can redirect the user to another page here
    } else {
        // User not found or incorrect password
        echo "Invalid username or password.";
    }
}

// Close the database connection
$conn->close();
?>
