<?php

include 'db_connect.php';


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Hash the password for security
    $hashed_password = md5($password);

    $check=$conn->query("SELECT * FROM customer where username ='$username' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
    if($check > 0){
        
        echo 'User Exists';
        exit;
    }

    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO customer (name, username, password, email,address, phone_number, dob) VALUES ('$name', '$username', '$hashed_password', '$email', '$address','$phone', '$dob')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
