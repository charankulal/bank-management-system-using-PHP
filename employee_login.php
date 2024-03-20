<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['emp_username'])) {
    // If logged in, redirect to dashboard
    header("Location: employee_dashboard.php");
    exit();
} 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
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
              <h4>Employee Login</h4>
            </div>
            <div class="card-body">
              <form action="" method="post">
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
                <button type="submit" class="btn btn-primary">Login</button>
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
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // MD5 hash the password
    $hashed_password = md5($password);

    // Query to fetch user details based on provided username and hashed password
    $sql = "SELECT * FROM employee WHERE username='$username' AND password='$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['emp_username'] = $row['username'];
        $_SESSION['emp_name'] = $row['name'];
        // Add other user data you may need in session

        // Redirect to dashboard or home page
        header("Location: employee_dashboard.php");
        
        // You can redirect the user to another page here
    } else {
        // User not found or incorrect password
        echo "Invalid username or password.";
    }
}

// Close the database connection
$conn->close();
?>

