<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    // If logged in, redirect to dashboard
    header("Location: index.php");
    exit();
} 
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Page</title>
    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
  </head>
  <body>
    <nav class="navbar bg-primary" data-bs-theme="dark">
      <div class="mx-3">
        <img src="assets/img/logo.png" alt="" height="60px" width="60px" />
        <span class="navbar-brand mb-0 h1 mx-3">Your Bank</span>
      </div>
    </nav>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4 class="text-center">Customer Registration</h4>
            </div>
            <div class="card-body">
              <form action="" method="post">
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="username">Username:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="phone"
                    name="phone"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="dob">Date of Birth:</label>
                  <input
                    type="date"
                    class="form-control"
                    id="dob"
                    name="dob"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="dob">Address</label>
                  <input
                    type="text"
                    class="form-control"
                    id="address"
                    name="address"
                    required
                  />
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary m-2">
                    Register
                  </button>
                  <a class="btn btn-warning m-2" href="./customer_login.php"
                    >Already Registered? Login here
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
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
        header('Location: ./landing_pages//customer_register_landing.html');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
